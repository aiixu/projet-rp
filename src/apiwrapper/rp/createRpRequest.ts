import { classToPlain, plainToClass, Expose } from "class-transformer";
import { environment } from "src/environments/environment";
import axios from "axios";

export class CreateRpRequest
{
    public async post(request: NonNullable<CreateRpRequestModel>): Promise<CreateRpResponseModel> {
        const response: any = await axios.post(`${environment.apiUrl}rps`, classToPlain(request));
        return plainToClass(CreateRpResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class CreateRpRequestModel
{
    @Expose({ name: "user_id" }) public userId: number;
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose() public content : string;
    @Expose() public title: string;
}

export class CreateRpResponseModel
{
    @Expose() public id: number;
    @Expose() public message: string;
}