import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { Router } from '@angular/router';
import axios from 'axios';
import { DeleteRpRequest, DeleteRpRequestModel } from 'src/apiwrapper/rp/deleteRpRequest';
import { GetRpsRequest, GetRpsRequestModel, GetRpsResponseRpModel } from 'src/apiwrapper/rp/getRpsRequest';
import { environment } from 'src/environments/environment';
import { ImagesService } from '../_services/images/images.service';
import { LoginService } from '../_services/login/login.service';

class ImageSnippet {
  constructor(public src: string, public file: File) {}
}

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  loading: boolean;
  rps: Array<GetRpsResponseRpModel>;
  selectedFile: ImageSnippet;

  constructor(private imageService: ImagesService, private router: Router, public loginService: LoginService) { 
    if(!loginService.isLoggedIn())
    {
      router.navigate([ "/connexion" ], 
      {
        state: {
          from: "profile"
        }
      });
    }
  }
  
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

  file=new FormControl('')
  file_data:any=''
  fileChange(event:any) {
    const fileList: FileList = event.target.files;

    //check whether file is selected or not
    if (fileList.length > 0) 
    {
      const file = fileList[0];
      
      //get file information such as name, size and type
      console.log('finfo', file.name, file.size, file.type);

      // max file size is 4 mb
      if((file.size / 1048576) <= 4)
      {
        let formData = new FormData();
        let info = { id: 2 , name: 'raja' }

        formData.append('file', file, file.name);
        formData.append('id','2');
        formData.append('tz',new Date().toISOString())
        formData.append('update','2')
        formData.append('info', JSON.stringify(info))

        this.file_data=formData
      }
      else
      {
        //this.snackBar.open('File size exceeds 4 MB. Please choose less than 4 MB','',{duration: 2000});
      }
    }
  }

  
  uploadFile()
    {
      axios.post(environment.apiUrl+'upload',this.file_data)
        .then(console.log)
        .catch(console.error);
    }
}
