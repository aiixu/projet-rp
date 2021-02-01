import axios from "axios";

export class CreateUserRequest
{
    public post(request: NonNullable<CreateUserRequestModel>): Promise<CreateUserResponseModel> {
        return axios.post("localhost/api/users", request);
    }
}

export class CreateUserRequestModel
{
    public username: string | undefined;
    public email: string | undefined;
    public isPublic: boolean | undefined;
    public passwordHash: string | undefined;
    public profilePicture: string | undefined;

    public firstName: string | undefined;
    public lastName: string | undefined;
}

export class CreateUserResponseModel
{
    public id: number | undefined;
}