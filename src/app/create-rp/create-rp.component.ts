import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-create-rp',
  templateUrl: './create-rp.component.html',
  styleUrls: ['./create-rp.component.css']
})
export class CreateRPComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }

  submitTickets(form: NgForm) {    
    const request: CreateRpRequest = new CreateRpRequest();
    const requestModel : CreateRpRequestModel = new CreateRpRequestModel();
    
    requestModel.senderName = form.value.Name;
    requestModel.senderMail = form.value.Email;
    requestModel.message = form.value.textarea;

    request.post(requestModel)
      .then((res: any) => {
        console.log(res);
    });

    form.reset();
  }
}