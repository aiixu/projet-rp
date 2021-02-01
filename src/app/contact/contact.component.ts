import { Component, OnInit } from '@angular/core';
import { GetUsersRequest, GetUsersRequestModel, GetUsersResponseModel } from 'src/apiwrapper/users/getUsersRequest';
@Component({
  selector: 'app-contact',
  templateUrl: './contact.component.html',
  styleUrls: ['./contact.component.css']
})
export class ContactComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }
  
}
