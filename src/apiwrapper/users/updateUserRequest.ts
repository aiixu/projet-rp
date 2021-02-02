import { Expose, plainToClass, classToPlain } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class UpdateUserRequest
{
    public async put(request: NonNullable<UpdateUserRequestModel>): Promise<UpdateUserResponseModel> {
        const response: any = await axios.put(`${environment.dburl}api/users/${request.id}`, classToPlain(request));
        return plainToClass(UpdateUserResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class UpdateUserRequestModel
{
    @Expose() public id: number;

    @Expose() public username: string;
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose({ name: "password_hash" }) public passwordHash: string;
    @Expose({ name: "profile_picture" }) public profilePicture: string;
}

export class UpdateUserResponseModel
{
    @Expose() public message: string;
}