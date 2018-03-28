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

// 예제1
io.on('connection', function (socket){

    socket.on('answer', function(data){
       console.log('Client Send Data:', data);

       answer_c++;

       io.sockets.emit('answer-sum',answer_c);
       console.log('answer counting: ', answer_c);
    });
});


let users = [
    {  id: 1, name: 'alice' },
    {  id: 2, name: 'bek' },
    {  id: 3, name: 'chris'  }
    ]
app.get('/users', (req, res) => {
    console.log('who get in here/users');
res.json(users)
});

app.post('/post', (req, res) => {
    console.log('who get in here post /users');
var inputData;

req.on('data', (data) => {
    inputData = JSON.parse(data);
});

req.on('end', () => {
    console.log("user_id : "+inputData.user_id + " , name : "+inputData.name);
});

res.write("OK!");
res.end();
});


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