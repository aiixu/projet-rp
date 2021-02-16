import { Component, ElementRef, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { GetUserRequest, GetUserRequestModel } from 'src/apiwrapper/users/getUserRequest';
import { LoginService } from './_services/login/login.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: [ './app.component.css' ]
})

export class AppComponent {
  title = 'projet-rp';
  @ViewChild('searchBarInput') searchBarInput: ElementRef;
  constructor(private router: Router, public loginService: LoginService) {
  }
  
  onSubmit(): void {
    const query: string = this.searchBarInput.nativeElement.value;

    if(query == "") { return; }
    
    this.router.navigate(
      [ "/search" ], 
      {
        queryParams: {
          q: query
        }
      })

    this.searchBarInput.nativeElement.value = "";
 }

 log(content: any): void {
   console.log(content);
 }
}
