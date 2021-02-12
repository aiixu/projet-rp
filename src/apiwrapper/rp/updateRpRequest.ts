import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class GetRpRequest
{
    // requete update = put, get = récupérer
    public async put(request: NonNullable<UpdateRpRequestModel>): Promise<UpdateRpResponseModel> {
        const response: any = await axios.put(`${environment.apiUrl}rps/${request.id}`);
        return plainToClass(UpdateRpResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class UpdateRpRequestModel
{
    @Expose() public id: number;
    @Expose() public content : string;
    @Expose() public title: string;

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