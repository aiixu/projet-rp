import { RequestModel, Request, ResponseModel } from "./request";

import { ClassConstructor, classToPlain, plainToClass } from "class-transformer";
import axios from "axios";

export abstract class CreateRequest extends Request
{
    protected constructor(tableName: string, method: string)
    { 
        super(tableName, method);
    }

    protected async execute<T extends ResponseModel>(cls: ClassConstructor<T>, request: NonNullable<RequestModel>) : Promise<T> {
        const response: any = await axios.post(super.getApiUrl(), classToPlain(request));
        return plainToClass(cls, response.data, { excludeExtraneousValues: true });
    }
}