import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { CreateUserRequest, CreateUserRequestModel } from 'src/apiwrapper/rpprojectapi';
import { LoginService } from '../_services/login/login.service';

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.css']
})
export class RegistrationComponent implements OnInit {

  constructor(public loginService: LoginService, private router: Router) { }

  ngOnInit(): void {
  }

  signup(form: NgForm): void {
    const request: CreateUserRequest = new CreateUserRequest();
    const requestModel: CreateUserRequestModel = new CreateUserRequestModel();

    requestModel.firstName = form.value.firstName;
    requestModel.lastName = form.value.lastName;
    requestModel.username = form.value.username;
    requestModel.passwordHash = form.value.passwordHash;
    requestModel.email = form.value.email;
    requestModel.isPublic = true;
    
    request.post(requestModel)
      .then(res => 
      {
        this.loginService.login(requestModel.username, requestModel.passwordHash);
        this.router.navigateByUrl("home");
      })
      .catch(console.error);
  }
}
