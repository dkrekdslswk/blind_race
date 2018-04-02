var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

// Mysql 노드 모듈 부분 
var mysql      = require('mysql');
var dbconfig   = require('./config/database.js');
var connection = mysql.createConnection(dbconfig);



app.get('/', function(req, res){
  res.send('Root');
});

app.post('/persons', function(req, res){
   
                                
  connection.query('SELECT * from users ', function(err, rows) {
    if(err) throw err;

    console.log('The solution is: ', rows);
//   var row = JSON.parse(rows);
    res.send(rows);      
  });
});

app.listen(app.get('port'), function () {
  console.log('Express server listening on port ' + app.get('port'));
});

//소켓아이오 -------------------------------------------------------------------
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

<<<<<<< HEAD
    socket.on('answer', function(data){
       console.log('Client Send Data:', data);

=======
//퀴즈 답받는 소켓 함수     
    socket.on('answer', function(data){
       console.log('Client Send Data:', data);
        
    var quizin = quiz+1;    
    var answer_query = "insert into playing_quizs values (1,"+count+","+quizin+",0,'"+data+ "','0')" ;    
        console.log('user',count);
    connection.query(answer_query, function(err, rows) {
    if(err) throw err;
        console.log('The solution is: ', rows);
      });
      
>>>>>>> efc7032725a8bb172272d550e0d3c1713d73cdbc
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
        quiz++;
        socket.emit('nextok',quiz);
        countdown = 20000;
        console.log('answer_sum add',quiz);
    });

    socket.on('count',function(data){

        setInterval(function() {
            countdown -= 1000;
            io.sockets.emit('timer', countdown);
            
            if(countdown == 0)
            {
                quiz++;
                socket.emit('nextok',quiz);
                countdown = 20000;
                console.log('timeend add',quiz);
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





<<<<<<< HEAD
/*kimseungmok*************************************/


var race_StudentCount = 0;
var racenav = '{\
                "race":[{\
                    "raceName":"스쿠스쿠문법1",\
                    "raceCount":30}],\
                "group":[{\
                    "groupName":"2학년 특강 A반",\
                    "groupStudentCount":6}]\
                }';

var user = '{\
                "student":[{\
                    "studentName":"김승목",\
                    "studentNick":"모기모기"}]\
                }';

var getJsonDate_user = JSON.parse(user);


var kim_app = require('express')();
var kim_http = require('http').Server(kim_app);
var kim_io = require('socket.io')(kim_http);
var user_conn = true;


/*kim_app.get('/',function (req, res) {
    res.sendFile(__dirname + '../resources/views/main');
});*/

kim_io.on('connection', function(socket){
    user_conn = true;
    race_StudentCount++;
    console.log('user in');


    socket.on('disconnect', function(){

        user_conn = false;
        race_StudentCount--;

        console.log('user out');
    });

    if (user_conn){

        //레이스 네비 정보 전송
        kim_io.sockets.emit('racenav data',racenav);

        //유저 정보 전송
        kim_io.sockets.emit('user data',user);

        //현재 접속자 수
        kim_io.sockets.emit('now user counting',race_StudentCount);

    }else{

        //나간 유저의 정보를 전송
        kim_io.sockets.emit('disc user',user);

        //현재 접속자 수
        kim_io.sockets.emit('now user counting',race_StudentCount);
    }

});

kim_http.listen(8891,function () {
    console.log('listening on *: 8891');

});
=======

>>>>>>> efc7032725a8bb172272d550e0d3c1713d73cdbc
