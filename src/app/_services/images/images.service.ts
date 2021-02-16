import { Injectable } from '@angular/core';
import axios from 'axios';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ImagesService {

  constructor() {}

  public uploadImage(image: File): Promise<Response> {
    const formData = new FormData();

    formData.append('image', image);

    return axios.post(`${environment.apiUrl}upload`, formData);
  }

}
