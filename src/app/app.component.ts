import { Component, ElementRef, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { GetUserRequest, GetUserRequestModel } from 'src/apiwrapper/users/getUserRequest';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})

export class AppComponent {
  title = 'projet-rp';
  @ViewChild('searchBarInput') searchBarInput: ElementRef;
  constructor(private router: Router) {
  }

  search(): void {
    console.log();
    
    // récupérer un utilisateur avec son identifiant unique
    const request: GetUserRequest = new GetUserRequest();
    const requestModel: GetUserRequestModel = new GetUserRequestModel(1);

    request.get(requestModel)
      .then(res => {
        // res.username = pseudo
        // res.isPublic = pseudo public ou privé
        // res.firstName = Prénom
        // res.lastName = Nom
        // res.profilePicture = URL photo de profil
      })
      .catch(console.error);
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
 }

 log(content: any): void {
   console.log(content);
 }
}
