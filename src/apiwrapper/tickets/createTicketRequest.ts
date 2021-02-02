import { Expose, plainToClass, classToPlain } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class CreateTicketRequest
{
    public async post(request: NonNullable<CreateTicketRequestModel>): Promise<CreateTicketResponseModel> {
        const response: any = await axios.post(`${environment.dburl}api/tickets`, classToPlain(request));
        return plainToClass(CreateTicketResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class CreateTicketRequestModel
{
    @Expose({ name: "sender_mail" }) public senderMail: string;
    @Expose({ name: "sender_name" }) public senderName: string;
    @Expose() public message: string;
    
    public constructor(senderMail: string, senderName: string, message: string)
    {
        this.senderMail = senderMail;
        this.senderName = senderName;
        this.message = message;
    }
}

export class CreateTicketResponseModel
{
    @Expose() public id: number;
}