import { Expose, Type, plainToClass } from 'class-transformer';
import axios from "axios";

export class GetUsersRequest
{
    public async get(request: NonNullable<GetUsersRequestModel>): Promise<GetUsersResponseModel> {        
        const response: any = await axios.get(`http://localhost/api/users?p=${request.page}&q=${request.query}`);       
        return plainToClass(GetUsersResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class GetUsersRequestModel
{
    @Expose() public page : number;
    @Expose() public query : string;

    public constructor(query: string = "", page: number = 1)
    {
        this.query = query;
        this.page = page;
    }
}

export class GetUsersResponseModel
{
    @Type(() => GetUsersResponseUserModel)
    @Expose() public users: Array<GetUsersResponseUserModel>;

    @Type(() => GetUsersResponsePagesModel)
    @Expose() public pages: GetUsersResponsePagesModel;
}

export class GetUsersResponseUserModel
{
    @Expose() public username: string;
    @Expose() public email: string;
    @Expose({ name: "is_public" }) public isPublic: boolean = false;
    @Expose({ name: "password_hash" }) public passwordHash: string;
    @Expose({ name: "profile_picture" }) public profilePicture: string;

    @Expose({ name: "first_name" }) public firstName: string;
    @Expose({ name: "last_name" }) public lastName: string;
}

export class GetUsersResponsePagesModel
{
    @Expose() public first: string;
    @Expose() public last: string;

    @Type(() => GetUsersResponsePageModel)
    @Expose() public pages: Array<GetUsersResponsePageModel>;
}

export class GetUsersResponsePageModel
{
    @Expose({ name: "is_current_page" }) public isCurrentPage: boolean;
    @Expose() public page: number;
    @Expose() public url: string;
}