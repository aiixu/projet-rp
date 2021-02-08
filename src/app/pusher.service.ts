import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment'

// import Pusher with browser, not NPM (je sais pas pourquoi mais ya écrit)
declare const Pusher: any;

@Injectable({
  providedIn: 'root'
})

export class PusherService {
  pusher: any;
  messagesChannel: any;

  constructor() { 
    this.pusher = new Pusher(environment.pusher.key, {
      // authentication function in api.js
      authEndpoint: `${environment.pusher.serverUrl}pusher/auth`
    });

    // listen to channel "private-messages"
    this.messagesChannel = this.pusher.subscribe("private-messages");
  }
}
