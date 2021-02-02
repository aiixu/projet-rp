import { ClassConstructor } from 'class-transformer';
import { environment } from 'src/environments/environment'

export abstract class Request
{
    protected tableName: string;
    protected method: string;

    protected constructor(tableName: string, method: string)
    {
        this.tableName = tableName;
        this.method = method;
    }

    protected abstract execute<T extends ResponseModel>(cls: ClassConstructor<T>, request: NonNullable<RequestModel>) : Promise<T>;

    protected getApiUrl(): string {
        return environment.dburl + environment.apiFolder + this.tableName;
    }
}

export abstract class RequestModel
{ }

export abstract class ResponseModel
{ }