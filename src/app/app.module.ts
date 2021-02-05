import { NgModule } from '@angular/core';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { ProfileComponent } from './profile/profile.component';
import { ContactComponent } from './contact/contact.component';
import { ApiComponent } from './api/api.component';
import { RegistrationComponent } from './registration/registration.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { CreateRPComponent } from './create-rp/create-rp.component';
import { WhoAreWeComponent } from './who-are-we/who-are-we.component';
import { MajorMinorComponent } from './major-minor/major-minor.component';
import { ApitestComponent } from './apitest/apitest.component';
import { FaqComponent } from './faq/faq.component';
<<<<<<< HEAD
import { AdministrationComponent } from './administration/administration.component';
=======
import { ViewProfileComponent } from './view-profile/view-profile.component';
>>>>>>> bea90f2be749decd2f79e91c38d8b450e890226f

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    
    ProfileComponent,
    ContactComponent,
    FaqComponent,
    ProfileComponent,
    ApiComponent,
    RegistrationComponent,
    ConnexionComponent,
    CreateRPComponent,
    WhoAreWeComponent,
    MajorMinorComponent,
    ApitestComponent,
<<<<<<< HEAD
    AdministrationComponent
=======
    ViewProfileComponent
>>>>>>> bea90f2be749decd2f79e91c38d8b450e890226f
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
