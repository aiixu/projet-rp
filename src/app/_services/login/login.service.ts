import { Injectable } from '@angular/core';
import axios from 'axios';
import { Expose, plainToClass } from 'class-transformer';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor() { }

  public async login(username: string, password: string): Promise<boolean> {
    const response: any = await axios.post(`${environment.apiUrl}auth/login`,
    {
      username: username,
      password: password
    });

    //return plainToClass(DeleteRpResponseModel, response.data, { excludeExtraneousValues: true });
    console.log(response);
    return response.success;
  }

  logout(): void { 
    localStorage.clear();
  }

  isLoggedIn(): boolean { 
    this.checkExpiration();
    return localStorage.getItem("token") != null;
  }

  getLoggedUser(): User | null { 
    if(!this.isLoggedIn()) { return null; }

    const userData: string | null = localStorage.getItem("user_data");
    if(userData == null)
    {
      this.logout();
      return null;
    }

    return plainToClass(User, userData);
  }

  checkExpiration(): void
  {
    const date: string | null = localStorage.getItem("token_expiration");
    if(date == null) { return; }

    if(Date.parse(date) <= Date.now())
    {
      this.logout();
    }
  }
}

export class User {
  @Expose() public id: number;
  @Expose() public username: string;
  @Expose() public email: boolean;
  @Expose({ name: "is_public" }) public isPublic: boolean;
  @Expose() public role: string;
}