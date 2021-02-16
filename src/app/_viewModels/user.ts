import { Expose } from "class-transformer";

export class UserModel 
{
    constructor(data: Partial<UserModel>) {
        Object.assign(this, data);
    }

    @Expose() public id: number;
    @Expose() public username: string;
    @Expose() public email: boolean;
    @Expose({ name: "is_public" }) public isPublic: boolean;
    @Expose() public role: string;
}