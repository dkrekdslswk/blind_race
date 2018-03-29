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
var answer_c = 0;
var quiz = 0;
var countdown = 20000;

// 예제1
io.on('connection', function (socket){
    var name = "user" + count++;
    console.log('connected',name);
    
    socket.on('answer', function(data){
       console.log('Client Send Data:', data);
        
       answer_c++;

       io.sockets.emit('answer-sum',answer_c);
       console.log('answer counting: ', answer_c);
    });
    
    var room_No = null;
    socket.on('join', function(room_num){
        room_No = room_num;
        socket.join(room_num);
        console.log('join!',room_No);
       
        
        if(answer_c == '5')
            io.sockets.emit('room_num','12');
    });
    socket.on('message',function(data){
       io.sockets.in('Name').emit('message',data);
       console.log('message',data);
    });
    
    socket.on('nextquiz',function(data){
        answer_c = 0 ;
        quiz++
        socket.emit('nextok',quiz);
        countdown = 20000;
    });

    socket.on('count',function(data){

        setInterval(function() {
            countdown -= 1000;
            io.sockets.emit('timer', countdown);
            console.log('timer',quiz);
            if(countdown == 0)
            {
                quiz++;
                socket.emit('nextok',quiz);
                countdown = 20000;
            }
        }, 1000);

    });

});
// 병찬이형 연습할 자리 





// io.on('connection', function(socket){ //3
//     console.log('user connected: ', socket.id);  //3-1
//     var name = "user" + count++;                 //3-1
//     io.to(socket.id).emit('change name',name);   //3-1
//
//     socket.on('disconnect', function(){ //3-2
//         console.log('user disconnected: ', socket.id);
//     });
//
//     socket.on('answer', function(text){
//        answer_c++;
//        console.log(answer_c);
//        io.emit('receive answer', answer_c);
//     });
//
//     socket.on('send message', function(name,text){ //3-3
//         var msg = name + ' : ' + text;
//         console.log(msg);
//         io.emit('receive message', msg);
//     });
// });

server.listen(8890, function(){ //4
    console.log('server on!');
});