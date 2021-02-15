import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import axios from 'axios';
import { environment } from 'src/environments/environment'
import { LoginService } from '../_services/login/login.service';

@Component({
  selector: 'app-connexion',
  templateUrl: './connexion.component.html',
  styleUrls: ['./connexion.component.css']
})
export class ConnexionComponent implements OnInit {
  constructor(private loginService: LoginService) { }

  ngOnInit(): void {
  }

  connect(form: NgForm) : void {
    console.log({   username: form.value["username"],
    password: form.value["password"]
  });
    
    /*axios.post(`${environment.apiUrl}users/auth`, {
        username: form.value["username"],
        password: form.value["password"]
      })
      .then(res => {
        console.log(res);
      })
      .catch(console.error);*/

    this.loginService.login(form.value["username"], form.value["password"]);

    form.reset();
  }
}
