// start:
//  cd chat-server 
//  node server.js
// test: 
//  postman
//  request: [GET] http://a44868420b8d.eu.ngrok.io
// how it works: User request -> Server -> Process request -> User response

// https://www.npmjs.com/package/dotenv
// load environment variables (in .env file)
require('dotenv').config();

// express server
const express = require("express");
const http = require("http");

// https://www.npmjs.com/package/body-parser
// parsing library
const bodyParser = require('body-parser');

// if process.env.PORT is set, use it, or use port 3000
const port = process.env.PORT || 3000;

// start express app
const app = express();

const api = require("./api.js");

// define middleware
// https://en.wikipedia.org/wiki/Middleware
app.use(bodyParser.json()); // use json as request/response objects
app.use(bodyParser.urlencoded({ extended: false }));
app.use((request, response, next) =>
{
    // allow any origin
    // if any site call this method, it's going to be able to use it
    // shouldn't use * (all) for security issues (mais on s'en branle)
    response.header("Access-Control-Allow-Origin", "*"); 

    // header par défaut
    response.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");

    next();
});

// root route (groot) of the program referes to api.js
app.use("/", api);
app.set("port", port);

// server creation
const server = http.createServer(app);
server.listen(port, () => {
    // called when server is running
    console.log(`Running on port ${port}`);
});