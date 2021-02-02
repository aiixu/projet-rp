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
    console.log(form.value);
    
    const request: CreateTicketRequest = new CreateTicketRequest();
      const requestBDD : CreateTicketRequestModel = new CreateTicketRequestModel(form.value.Name, form.value.Email, form.value.textarea);
       
      console.log(requestBDD);
      request.post(requestBDD)
        .then((res: any) => {
          console.log(res);
          form.reset();
  })
}

}
