import { Component, OnInit } from '@angular/core';
import { DeleteRpRequest, DeleteRpRequestModel } from 'src/apiwrapper/rp/deleteRpRequest';
import { GetRpsRequest, GetRpsRequestModel, GetRpsResponseRpModel } from 'src/apiwrapper/rp/getRpsRequest';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  loading: boolean;
  rps: Array<GetRpsResponseRpModel>;

  constructor() { }

  ngOnInit(): void {
    const request: GetRpsRequest = new GetRpsRequest();
    const requestModel: GetRpsRequestModel = new GetRpsRequestModel();

    requestModel.userId = 50;

    this.loading = true;
    request.get(requestModel)
      .then(res => {
        this.rps = res.rps;
      })
      .catch(console.error)
      .then(() => this.loading = false);
  }
  
  deleteRp(id: number, index: number) {    
    const request: DeleteRpRequest = new DeleteRpRequest();
    const requestModel : DeleteRpRequestModel = new DeleteRpRequestModel(id);
    
    request.delete(requestModel)
      .then(res => {
        if(res.success)
        {
          this.rps.splice(index, 1);
        }
      })
      .catch(console.error);
  }
}
