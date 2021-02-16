import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { LoginService } from '../_services/login/login.service';

@Component({
  selector: 'app-connexion',
  templateUrl: './connexion.component.html',
  styleUrls: ['./connexion.component.css']
})
export class ConnexionComponent implements OnInit {
  constructor(public loginService: LoginService, private router: Router, private route: ActivatedRoute) 
  { }

  ngOnInit(): void {
  }

  async connect(form: NgForm) : Promise<void> {
    console.log({ username: form.value["username"], password: form.value["password"] });

    const success = await this.loginService.login(form.value["username"], form.value["password"])
    
    if(success)
    {
      const from: string = this.route.snapshot.queryParamMap.get("from") || "home";
      this.router.navigateByUrl(from);
    }
    else
    {
      alert("Mot de passe ou nom d'utilisateur incorrect");
    }    

    form.reset();
  }
}
