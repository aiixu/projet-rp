import { Component, OnInit } from '@angular/core';
import { PusherService } from '../pusher.service';

// interface is like class but class which implements the interface require the fields
// if MessageClass implements (extends in PHP) IMessage, then MessageClass has to declare a text and a user variable
interface IMessage {
  text: string;
  user: string;
}

@Component({
  selector: 'app-messages',
  templateUrl: './messages.component.html',
  styleUrls: ['./messages.component.css']
})

export class MessagesComponent implements OnInit {
  messages: Array<IMessage>;

  username: string;
  messageText: string;

  constructor(private pusherService: PusherService) { 
    this.messages = [];
  }

  ngOnInit(): void {
    // on new message received
    this.pusherService.messagesChannel.bind("client-new-message", (msg: any) => {
      // add message to the list
      this.messages.push(msg);
    });
  }

  sendMessage(username: string, messageText: string)
  {
    // prepare message
    const message: IMessage = {
      user: username,
      text: messageText
    }

    // send message
    this.pusherService.messagesChannel.trigger("client-new-message", message);
    
    // add sent messages to message list
    this.messages.push(message);
  }
}
