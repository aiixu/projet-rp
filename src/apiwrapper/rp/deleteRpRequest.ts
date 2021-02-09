import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class DeleteRpRequest
{
    public async delete(request: NonNullable<DeleteRpRequestModel>): Promise<DeleteRpResponseModel> {
        const response: any = await axios.delete(`${environment.apiUrl}rps/${request.id}`);
        return plainToClass(DeleteRpResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class DeleteRpRequestModel
{
    @Expose() public id: number;

    constructor(id: number)
    {
        this.id = id;
    }
}

export class DeleteRpResponseModel
{
    @Expose() public message: string;
    @Expose() public success: boolean;
}