import { Expose, Type, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class GetTicketsRequest
{
    public async get(request: NonNullable<GetTicketsRequestModel>): Promise<GetTicketsResponseModel> {        
        const response: any = await axios.get(`${environment.apiUrl}tickets?page=${request.page}&query=${request.query}`);       
        return plainToClass(GetTicketsResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class GetTicketsRequestModel
{
    @Expose() public page : number;
    @Expose() public query : string;

    public constructor(query: string = "", page: number = 1)
    {
        this.query = query;
        this.page = page;
    }
}

export class GetTicketsResponseModel
{
    @Type(() => GetTicketsResponseTicketModel)
    @Expose() public tickets: Array<GetTicketsResponseTicketModel>;

    @Type(() => GetTicketsResponsePagesModel)
    @Expose() public pages: GetTicketsResponsePagesModel;
}

export class GetTicketsResponseTicketModel
{
    @Expose({ name: "sender_mail" }) public senderMail: string;
    @Expose({ name: "sender_name" }) public senderName: string;
    @Expose() public message: string;
    @Expose() public date: Date;
}

export class GetTicketsResponsePagesModel
{
    @Expose() public first: string;
    @Expose() public last: string;

    @Type(() => GetTicketsResponsePageModel)
    @Expose() public pages: Array<GetTicketsResponsePageModel>;
}

export class GetTicketsResponsePageModel
{
    @Expose({ name: "is_current_page" }) public isCurrentPage: boolean;
    @Expose() public page: number;
    @Expose() public url: string;
}