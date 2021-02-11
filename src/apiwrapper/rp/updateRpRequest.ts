import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class GetRpRequest
{
    public async get(request: NonNullable<UpdateRpRequestModel>): Promise<UpdateRpResponseModel> {
        const response: any = await axios.get(`${environment.apiUrl}rps/${request.id}`);
        return plainToClass(UpdateRpResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class UpdateRpRequestModel
{
    @Expose() public id: number;
    @Expose() public content : string;
    @Expose() public title: string;
    @Expose() public date: Date;
    constructor(id: number)
    {
        this.id = id;
    }

}
export class UpdateRpResponseModel
{
    @Expose() public message: string;
    @Expose() public success: boolean;
}

/*export class GetRpResponseModel
{
    @Expose({ name: "user_id" }) public userId: number;
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose() public content : string;
    @Expose() public title: string;
    @Expose() public date: Date;
}
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
}*/