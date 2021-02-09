import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { GetUsersRequest, GetUsersRequestModel, GetUsersResponseUserModel } from 'src/apiwrapper/users/getUsersRequest';

@Component({
  selector: 'app-view-profile',
  templateUrl: './view-profile.component.html',
  styleUrls: ['./view-profile.component.css']
})

export class ViewProfileComponent implements OnInit {
  user: GetUsersResponseUserModel;

  constructor(private route: ActivatedRoute) { }

  ngOnInit(): void {
    const username = this.route.snapshot.paramMap.get("username");

    if(!username) {
      return;
    }

    const request: GetUsersRequest = new GetUsersRequest();
    const requestModel: GetUsersRequestModel = new GetUsersRequestModel();

    requestModel.query = username;

    request.get(requestModel)
      .then(res => {
        const user = res.users.filter(x => x.username.toLowerCase() == username.toLowerCase())[0];
        if(!res.users.filter(x => x.username.toLowerCase() == username.toLowerCase())[0])
        {
          return;
        }

        this.user = user;
      })
      .catch(console.error);
  }
}
