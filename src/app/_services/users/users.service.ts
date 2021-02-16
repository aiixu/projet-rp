import { Injectable } from '@angular/core';
import { GetUsersResponseModel, GetUsersRequest, GetUsersRequestModel } from 'src/apiwrapper/users/getUsersRequest';
import { UserModel } from 'src/app/_viewModels/user';

@Injectable({
  providedIn: 'root'
})

export class UsersService {

  constructor() { }

  public async getUserByName(username: string): Promise<UserModel | null>
  {
    const request: GetUsersRequest = new GetUsersRequest();
    const requestModel: GetUsersRequestModel = new GetUsersRequestModel();

    requestModel.query = username;

    const res: GetUsersResponseModel = await request.get(requestModel);
    const user = res.users.filter(x => x.username.toLowerCase() == username.toLowerCase())[0];
    if(!res.users.filter(x => x.username.toLowerCase() == username.toLowerCase())[0])
    {
      return null;
    }

    // todo: end
    return null;
  }
}
