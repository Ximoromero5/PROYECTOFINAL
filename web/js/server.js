//Express instance
let express = require('express');
let app = express();

//Http instance
let http = require('http').createServer(app);

//Socket instance
let io = require('socket.io')(http);

io.on("connection", function (socket) {
    console.log('user connected', socket.id);
});

//Start server
http.listen(3000, function () {
    console.log('Server Started');
});