import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class GetRpRequest
{
    public async get(request: NonNullable<GetRpRequestModel>): Promise<GetRpResponseModel> {
        const response: any = await axios.get(`${environment.apiUrl}rps/${request.id}`);
        return plainToClass(GetRpResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class GetRpRequestModel
{
    @Expose() public id: number;

    constructor(id: number)
    {
        this.id = id;
    }
}

export class GetRpResponseModel
{
    @Expose({ name: "user_id" }) public userId: number;
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose() public content : string;
    @Expose() public title: string;
    @Expose() public date: Date;
}