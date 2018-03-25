var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

server.listen(8890);


//소켓io 연결 비연결 !
io.on('connection',function(socket){
    console.log('a user connected');
 
    socket.on('disconnect',function(){
        console.log('a user disconnected');
    });
});

// ---------------------------------------------- 연결처리작업 
//changes
var count=1;
io.on('connection', function(socket){ //3
    console.log('user connected: ', socket.id);  //3-1
    var name = "user" + count++;                 //3-1
    io.to(socket.id).emit('change name',name);   //3-1

    socket.on('disconnect', function(){ //3-2
        console.log('user disconnected: ', socket.id);
    });

    socket.on('send message', function(name,text){ //3-3
        var msg = name + ' : ' + text;
        console.log(msg);
        io.emit('receive message', msg);
    });
});

server.listen(8890, function(){ //4
    console.log('server on!');
});