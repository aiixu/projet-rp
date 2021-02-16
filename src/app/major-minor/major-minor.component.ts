import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { LoginService } from '../_services/login/login.service';

@Component({
  selector: 'app-major-minor',
  templateUrl: './major-minor.component.html',
  styleUrls: ['./major-minor.component.css']
})
export class MajorMinorComponent implements OnInit {

  constructor(private router: Router, public loginService: LoginService) {
    if(!loginService.isLoggedIn())
    {
      router.navigate([ "/connexion" ], 
      {
        state: {
          from: "major-minor"
        }
      });
    }
  }

  ngOnInit(): void {
  }

}
