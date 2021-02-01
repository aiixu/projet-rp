import { Expose, plainToClass } from 'class-transformer';
import axios from "axios";

export class DeleteUserRequest
{
    public async delete(request: NonNullable<DeleteUserRequestModel>): Promise<DeleteUserResponseModel> {
        const response: any = await axios.delete(`http://localhost/api/users/${request.id}`);
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
}