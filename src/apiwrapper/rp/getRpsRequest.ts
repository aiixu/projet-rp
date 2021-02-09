import { Expose, Type, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class GetRpsRequest
{
    public async get(request: NonNullable<GetRpsRequestModel>): Promise<GetRpsResponseModel> {      
        const response: any = await axios.get(`${environment.apiUrl}rp?page=${request.page}&query=${request.query}&user=`);
        return plainToClass(GetRpsResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class GetRpsRequestModel
{
    @Expose() public page : number;
    @Expose() public query : string;
    @Expose({ name: "user_id" }) public userId: number = -1;

    public constructor(query: string = "", page: number = 1, userId: number = -1)
    {
        this.query = query;
        this.page = page;
        this.userId = userId;
    }
}

export class GetRpsResponseModel
{
    @Type(() => GetRpsResponseRpModel)
    @Expose() public Rps: Array<GetRpsResponseRpModel>;

    @Type(() => GetRpsResponsePagesModel)
    @Expose() public pages: GetRpsResponsePagesModel;
}

export class GetRpsResponseRpModel
{
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose({ name: "user_id"}) public userId: number;
    @Expose() public content : string;
    @Expose() public title: string;
    @Expose() public date: Date;
}

export class GetRpsResponsePagesModel
{
    @Expose() public first: string;
    @Expose() public last: string;

    @Type(() => GetRpsResponsePageModel)
    @Expose() public pages: Array<GetRpsResponsePageModel>;
}

export class GetRpsResponsePageModel
{
    @Expose({ name: "is_current_page" }) public isCurrentPage: boolean;
    @Expose() public page: number;
    @Expose() public url: string;
}