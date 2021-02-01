import { Expose, plainToClass } from 'class-transformer';
import axios from "axios";
import { environment } from 'src/environments/environment';

export class DeleteUserRequest
{
    public async delete(request: NonNullable<DeleteUserRequestModel>): Promise<DeleteUserResponseModel> {
        const response: any = await axios.delete(`${environment.dburl}api/users/${request.id}`);
        return plainToClass(DeleteUserResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class DeleteUserRequestModel
{
    @Expose() public id: number;

    constructor(id: number)
    {
        this.id = id;
    }
}

export class DeleteUserResponseModel
{
    @Expose() public message: string;
    @Expose() public success: boolean;
}