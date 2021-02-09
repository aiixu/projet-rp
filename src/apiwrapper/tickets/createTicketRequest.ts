import { Expose } from "class-transformer";
import { CreateRequest } from "../generic/createRequest";
import { RequestModel, ResponseModel } from "../generic/request";

export class CreateTicketRequest extends CreateRequest
{
    public async post(request: NonNullable<CreateTicketRequestModel>): Promise<CreateTicketResponseModel> {
        return super.execute(CreateTicketResponseModel, request);
    }

    public constructor()
    {
        super("tickets");
    }
}

export class CreateTicketRequestModel extends RequestModel
{
    @Expose({ name: "sender_mail" }) public senderMail: string;
    @Expose({ name: "sender_name" }) public senderName: string;
    @Expose() public message: string;
}

export class CreateTicketResponseModel extends ResponseModel
{
    @Expose() public id: number;
}