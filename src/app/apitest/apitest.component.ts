import { Component, OnInit } from '@angular/core';
import { CreateUserRequest, CreateUserRequestModel } from 'src/apiwrapper/users/createUserRequest';
import { GetUsersRequest, GetUsersRequestModel, GetUsersResponseModel } from 'src/apiwrapper/users/getUsersRequest';

@Component({
  selector: 'app-apitest',
  templateUrl: './apitest.component.html',
  styleUrls: ['./apitest.component.css']
})

export class ApitestComponent implements OnInit {
  response: GetUsersResponseModel;

  constructor() { }

  ngOnInit(): void {

  

    
      

  const userArray :Array <any> = [

{
  username: "michou",
  email: "fistpowerl@gmail.com",
    isPublic: true,
    passwordHash: "anusette",
  

},
{
  username: "FionaFiona",
  email: "GinetteSalunl@gmail.com",
    isPublic: false,
    passwordHash: "abourricheus",
  


},
{

  username: "bicheneuve",
  email: "fandechasse@gmail.com",
    isPublic: false,
    passwordHash: "aka47",



},
{


  username: "jeanpierresalun69",
  email: "jeanpierresalun69",
    isPublic: false,
    passwordHash: "pupusuretre",


},
{


  username: "Zovirax",
  email: "pustul@gmail.com",
    isPublic: false,
    passwordHash: "canicheturge",

},
{



  username: "samVanZuZu",
  email: "rustthebest@gmail.com",
    isPublic: false,
    passwordHash: "linuxpower",


},
{
  username: "acabblanc",
  email: "jenevotepasfn@gmail.com",
    isPublic: false,
    passwordHash: "marinejtm",



},

{


  username: "LeKiKiDeTouLesKiKi",
  email: "designforlifet@gmail.com",
    isPublic: true,
    passwordHash: "photoshopmylove",


},
{


  username: "darksasuke22",
  email: "briochainpuissant@gmail.com",
    isPublic: false,
    passwordHash: "le29cdelamerde",




},
{
username: "petitcanichejouflu",
email: true,
  passwordHash: "jaimelespates",
},

{
  username: "placeholder5556789",
  email: "japanlove@gmail.com",
    isPublic: false,
    passwordHash: "mangaforlife",



},

{
  username: "cancoillotteLe2",
  email: "fromageaulait@gmail.com",
    isPublic: false,
    passwordHash: "sojapower",

}

  ];

  for(const user of userArray)
{
  const requestBDD : CreateUserRequestModel = new CreateUserRequestModel();
  requestBDD.username = user.username;
  requestBDD.passwordHash = user.passwordHash;
  requestBDD.email =user.email;
  requestBDD.isPublic = user.isPublic;
  const request: CreateUserRequest = new CreateUserRequest();
  request.post(requestBDD)
  .then((res) => {
   console.log(res);
  })
  .catch(console.error);
      
  }
  

}
/*
const users: Array<any> = [ 
  {  
    username: "michel",
    email: "michel@gmail.com",
    isPublic: true,
    passwordHash: "a"
  },
  {  
    username: "michel2",
    email: "michel2@gmail.com",
    isPublic: false,
    passwordHash: "a"
  },
];

for(const user of users)
{
    console.log(user.username);
    console.log(user.email);
    console.log(user.isPublic);
    console.log(user.passwordHash);
}*/
}