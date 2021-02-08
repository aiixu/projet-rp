// load environment variables (in .env file)
require("dotenv").config();

const express = require("express");
const router = express.Router();

// https://www.npmjs.com/package/pusher
const Pusher = require("pusher");

// load config from .env file
const pusher = new Pusher({
    appId: process.env.APP_ID,
    key: process.env.KEY,
    secret: process.env.SECRET
});

router.get("/", (req, res) => {
    // write text in response
    res.send("GET /");
});

// authentication
router.post("/pusher/auth", (req, res) => {
    console.log("POST /pusher/auth");

    const socketId = req.body.socket_id;
    const channel = req.body.channel_id;

    // authenticate with pusher
    const auth = pusher.authenticate(socketId, channel);
    res.send(auth);
});

// export router so other apps can use it
module.exports = router;