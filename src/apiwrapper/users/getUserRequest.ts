import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class GetUserRequest
{
    public async get(request: NonNullable<GetUserRequestModel>): Promise<GetUserResponseModel> {
        const response: any = await axios.get(`${environment.dburl}api/users/${request.id}`);
        return plainToClass(GetUserResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class GetUserRequestModel
{
    @Expose() public id: number;

    constructor(id: number)
    {
        this.id = id;
    }
}

export class GetUserResponseModel
{
    @Expose() public username: string;
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose({ name: "profile_picture" }) public profilePicture: string;

    @Expose({ name: "first_name" }) public firstName: string;
    @Expose({ name: "last_name" }) public lastName: string;
}