import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import axios from 'axios';
import { plainToClass } from 'class-transformer';
import { UserModel } from 'src/app/_viewModels/user';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private router: Router) { }

  public async login(username: string, password: string): Promise<boolean> {
    try
    {
      const response: any = await axios.post(`${environment.apiUrl}auth/login`,
      {
        username: username,
        password: password
      });
  
      console.log(response.data);
      if(response.data.success)
      {
        localStorage.setItem("token", response.data.token);
        localStorage.setItem("token_expiration", response.data.expiration_date);
        localStorage.setItem("user_data", JSON.stringify(response.data.user));
  
        return true;
      }
      else
      {
        return false;
      }
    }
    catch
    {
      return false;
    }
  }

  logout(): void { 
    const username: string | undefined = this.getLoggedUser()?.username;
    if(username == undefined) { return; }

    localStorage.clear();
    console.log("a");
    
    axios.post(`${environment.apiUrl}auth/logout`,
      {
        username: username
      })
      .then(res =>
      {
        
        const currentUrl = this.router.url;
        this.router.navigateByUrl('/', {skipLocationChange: true}).then(() => {
            this.router.navigate([currentUrl]);
        });
      });
  }

  isLoggedIn(): boolean { 
    this.checkExpiration();
    return localStorage.getItem("token") != null;
  }

  getLoggedUser(): UserModel | null { 
    if(!this.isLoggedIn()) { return null; }

    const userData: string | null = localStorage.getItem("user_data");
    if(userData == null)
    {
      this.logout();
      return null;
    }

    return new UserModel(JSON.parse(userData));
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