import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { CreateTicketRequest, CreateTicketRequestModel } from 'src/apiwrapper/tickets/createTicketRequest';

@Component({
  selector: 'app-contact',
  templateUrl: './contact.component.html',
  styleUrls: ['./contact.component.css']
})

export class ContactComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }
  
  submitTickets(form: NgForm) {    
    const request: CreateTicketRequest = new CreateTicketRequest();
    const requestModel : CreateTicketRequestModel = new CreateTicketRequestModel();
    
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
