var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require("redis");

server.listen(8890);


//소켓io 연결 비연결 !
io.on('connection',function(socket){
    console.log('a user connected');
 
    socket.on('disconnect',function(){
        console.log('a user disconnected');
    });
});

// ---------------------------------------------- 연결처리작업 

