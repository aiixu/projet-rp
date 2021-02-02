import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';
import axios from "axios";

export class DeleteTicketRequest
{
    public async delete(request: NonNullable<DeleteTicketRequestModel>): Promise<DeleteTicketResponseModel> {
        const response: any = await axios.delete(`${environment.dburl}api/tickets/${request.id}`);
        return plainToClass(DeleteTicketResponseModel, response.data, { excludeExtraneousValues: true });
    }
}

export class DeleteTicketRequestModel
{
    @Expose() public id: number;

    constructor(id: number)
    {
        this.id = id;
    }
}

export class DeleteTicketResponseModel
{
    @Expose() public message: string;
    @Expose() public success: boolean;
}