import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { IInfo } from 'src/app/_viewModels/info';

@Injectable({
  providedIn: 'root'
})

export class EmailService {

  constructor(private http: HttpClient) { }

  sendEmail(obj: any): Observable<IInfo> {
    return this.http.post<IInfo>('http://localhost:3000/sendFormData', obj)
  }
}
