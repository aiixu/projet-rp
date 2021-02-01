import { Component, OnInit } from '@angular/core';
import { GetUsersRequest, GetUsersRequestModel, GetUsersResponseModel } from 'src/apiwrapper/users/getUsersRequest';

@Component({
  selector: 'app-apitest',
  templateUrl: './apitest.component.html',
  styleUrls: ['./apitest.component.css']
})

export class ApitestComponent implements OnInit {
  response: GetUsersResponseModel;

  constructor() { }

  ngOnInit(): void {
    const request: GetUsersRequest = new GetUsersRequest();
    const requestModel: GetUsersRequestModel = new GetUsersRequestModel();

    request.get(requestModel)
      .then((res) => {
        this.response = res;
      })
      .catch(console.error);
  }
}