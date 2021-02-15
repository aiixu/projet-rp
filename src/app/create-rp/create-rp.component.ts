import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { CreateRpRequest, CreateRpRequestModel } from 'src/apiwrapper/rp/createRpRequest';

@Component({
  selector: 'app-create-rp',
  templateUrl: './create-rp.component.html',
  styleUrls: ['./create-rp.component.css']
})
export class CreateRPComponent implements OnInit {
  constructor(private router: Router) { 
  }

  ngOnInit(): void {
  }

  createRp(form: NgForm) {    
    const request: CreateRpRequest = new CreateRpRequest();
    const requestModel : CreateRpRequestModel = new CreateRpRequestModel();
    
    requestModel.userId = 50;
    requestModel.title = form.value.title;
    requestModel.content = form.value.description + "\n" + form.value.text;
    requestModel.isPublic = form.value.isPublic;

    request.post(requestModel)
      .then(res => {
        const id: number = res.id;
        if(id == undefined)
        {
          return;
        }

        const route: string = `/users/darksasuke22/rps/${id}`;
        this.router.navigateByUrl(route);
      })
      .catch(console.error);

    form.reset();
  }
}