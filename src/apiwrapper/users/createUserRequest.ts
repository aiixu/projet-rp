import { Expose, plainToClass, classToPlain } from 'class-transformer';
import axios from "axios";
import { environment } from 'src/environments/environment';

export class CreateUserRequest
{
    public async post(request: NonNullable<CreateUserRequestModel>): Promise<CreateUserResponseModel> {
        const response: any = await axios.post(`${environment.dburl}api/users`, classToPlain(request));
        return plainToClass(CreateUserResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class CreateUserRequestModel
{
    @Expose() public username: string;
    @Expose() public email: string;
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose({ name: "password_hash" }) public passwordHash: string;
    @Expose({ name: "profile_picture" }) public profilePicture: string;

    @Expose({ name: "first_name" }) public firstName: string;
    @Expose({ name: "last_name" }) public lastName: string;
}

export class CreateUserResponseModel
{
    @Expose() public id: number;
    @Expose() public message: string;
}