import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class GetTicketRequest
{
    public async get(request: NonNullable<GetTicketRequestModel>): Promise<GetTicketResponseModel> {
        const response: any = await axios.get(`${environment.apiUrl}tickets/${request.id}`);
        return plainToClass(GetTicketResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class GetTicketRequestModel
{
    @Expose() public id: number;

    constructor(id: number)
    {
        this.id = id;
    }
}

export class GetTicketResponseModel
{
    @Expose({ name: "sender_mail" }) public senderMail: string;
    @Expose({ name: "sender_name" }) public senderName: string;
    @Expose() public message: string;
    @Expose() public date: Date;
}