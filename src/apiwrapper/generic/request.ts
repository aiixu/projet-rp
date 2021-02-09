import { ClassConstructor } from 'class-transformer';
import { environment } from 'src/environments/environment'

export abstract class Request
{
    protected tableName: string;

    protected constructor(tableName: string)
    {
        this.tableName = tableName;
    }

    protected abstract execute<T extends ResponseModel>(cls: ClassConstructor<T>, request: NonNullable<RequestModel>) : Promise<T>;

    protected getApiUrl(): string {
        return environment.apiUrl + this.tableName;
    }
}

export abstract class RequestModel
{ }

export abstract class ResponseModel
{ }