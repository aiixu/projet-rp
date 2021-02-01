import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { HomeComponent } from './home/home.component';
import { ProfileComponent } from './profile/profile.component';
import {ContactComponent } from './contact/contact.component';
import {RegistrationComponent } from './registration/registration.component';

import { ApiComponent } from './api/api.component';
import { FaqComponent } from './faq/faq.component';

const routes: Routes = [
  {
    path: "home",
    component: HomeComponent
  },
  {
    path: "profile",
    component: ProfileComponent
  },
  {
    path: "contact",
    component: ContactComponent
  },
  {
    path: "registration",
    component: RegistrationComponent
  },
  {
    path: "faq",
    component: FaqComponent
  },
  {
    path: "api",
    component: ApiComponent,


    children: [
      {
        path: "home",
        component: HomeComponent
      }
    ]
  },
  {
    path: "",
    redirectTo: "/home",
    pathMatch: "full"
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})

export class AppRoutingModule { }
