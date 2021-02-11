import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { GetRpRequest, GetRpRequestModel, GetRpResponseModel } from 'src/apiwrapper/rp/getRpRequest';

import { jsPDF } from 'jspdf';

@Component({
  selector: 'app-view-rp',
  templateUrl: './view-rp.component.html',
  styleUrls: ['./view-rp.component.css']
})
export class ViewRpComponent implements OnInit {
  response : GetRpResponseModel;

  constructor(private route: ActivatedRoute) { }

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get("id");

    const request: GetRpRequest = new GetRpRequest();
    // on créé un objet qui est le contenu de la requête
    const requestModel: GetRpRequestModel = new GetRpRequestModel(Number(id));

    // on envoie la requête
    request.get(requestModel)
      // une fois qu'elle a retourné quelque chose,
      .then((res) => {
        // on la stock dans le component
        console.log(res);
        
        this.response = res;
      })
      // en cas d'erreur, on l'affiche dans la console
      .catch(console.error);       
  }

  exportPdf(): void {
    const doc = new jsPDF();
    doc.text(this.getElm("title"), 15, 15);
    doc.text(this.getElm("date"), 15, 20);
    doc.save("out.pdf");
  }

  getElm(id: string) : string {
    return document.getElementById(id)?.innerHTML || `[NOTFOUND:${id}]`;
  }
}
