import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { GetRpRequest, GetRpRequestModel, GetRpResponseModel } from 'src/apiwrapper/rp/getRpRequest';

import { jsPDF } from 'jspdf';
import html2canvas from 'html2canvas';
import { DeleteRpRequest, DeleteRpRequestModel } from 'src/apiwrapper/rp/deleteRpRequest';

@Component({
  selector: 'app-view-rp',
  templateUrl: './view-rp.component.html',
  styleUrls: ['./view-rp.component.css']
})
export class ViewRpComponent implements OnInit {
  response : GetRpResponseModel;
  id: number;

  constructor(private router: Router, private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.id = Number(this.route.snapshot.paramMap.get("id"));

    const request: GetRpRequest = new GetRpRequest();
    // on créé un objet qui est le contenu de la requête
    const requestModel: GetRpRequestModel = new GetRpRequestModel(this.id);

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
    const elm: HTMLElement | null = document.getElementById("content");
    if(elm == null) { return; }
    
    html2canvas(elm, {scrollX: -5}).then(canvas => {
      const imgWidth = 190;
      const imgHeight = canvas.height * imgWidth / canvas.width;
      const contentDataURL = canvas.toDataURL("image/png");
      const pdf = new jsPDF("p", "mm", "a4");
      
      pdf.addImage(contentDataURL, "PNG", 10, 10, imgWidth, imgHeight)
      pdf.save(`${this.response.title}.pdf`);
    });
  }

  deleteRp(): void {
    const request: DeleteRpRequest = new DeleteRpRequest();
    
    request.delete(new DeleteRpRequestModel(this.id))
      .then(res =>
      {
        if(res.success)
        {
          alert("Le RP à été supprimé");
          const username: string | null = this.route.snapshot.paramMap.get("username");
          if(username != null)
          {
            this.router.navigateByUrl(`/users/${username}`);
          }
          else
          {
            this.router.navigateByUrl(`/home`);
          }
        }
      })
      .catch(console.error);
  }
}
