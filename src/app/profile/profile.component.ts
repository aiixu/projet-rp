import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { DeleteRpRequest, DeleteRpRequestModel } from 'src/apiwrapper/rp/deleteRpRequest';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }
  
  createRp(form: NgForm) {    
    const request: DeleteRpRequest = new DeleteRpRequest();
    const requestModel : DeleteRpRequestModel = new DeleteRpRequestModel(7);
    
    requestModel.user_id = 7;
    requestModel. = form.value.title;
    requestModel.content = form.value.textRp;
    requestModel.is_public = form.value.isPublic;
    console.log(DeleteRpRequest);

    request.post(requestModel)
      .then((res: any) => {
        console.log(res);
      })
      .catch(console.error);

    form.reset();
  }

}
