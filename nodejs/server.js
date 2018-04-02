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
var countdown = 10000;

//타이머온?
var timerOn = true;
var Timer ;


io.on('connection', function (socket){
    var name = "user" + count++;
    console.log('connected',name);

    // 타이머 시작함수
    socket.on('count',function(data){
            Timer = setInterval(function () {
                countdown -= 1000;
                io.sockets.emit('timer', countdown);
            }, 1000);
            console.log('타임온','그만');
            if( data == '1')
                quiz = 0 ; socket.emit('nextok',quiz);
    });

    socket.on('count_off', function(data){
        quiz++;
        countdown = 10000;
        socket.emit('nextok',quiz);
        clearInterval(Timer);
        socket.emit('mid_ranking' ,data);
        console.log('타임 스탑', '제발');
    });

//퀴즈 답받는 소켓 함수
    socket.on('answer', function(answer_num , student_num , nickname){
        console.log('Client Send Data:', answer_num);
        var quizin = quiz+1;
        // 문제리스트번호, 학생등록번호, 퀴즈 몇번문제, 재시험여부(0,1) , 몇번골랐는지 , '오답노트'
        var answer_query = "insert into playing_quizs values (1,"+student_num+","+quizin+",0,'"+answer_num+ "','0')" ;
        console.log('user',count);
        connection.query(answer_query, function(err, rows) {
            if(err) throw err;
            console.log('The solution is: ', rows);
        });
        answer_c++;
        io.sockets.emit('answer-sum',answer_c);
        console.log('answer counting: ', answer_c);
    });



    //
    // var room_No = null;
    // socket.on('join', function(room_num){
    //     room_No = room_num;
    //     socket.join(room_num);
    //     console.log('join!',room_No);
    //     if(answer_c == '5')
    //         io.sockets.emit('room_num','12');
    // });
    //
    // //룸참가
    // socket.on('joinroom',function(student_num , nickname){
    //     //   io.sockets.in('Name').emit('joinroom',student_num , nickname);
    //     io.sockets.emit('joinroom',student_num , nickname);
    //     console.log('joinroom',student_num);
    // });
    //
    // socket.on('nextquiz',function(data){
    //     //다음문제로 가기전 응답자수를 0으로 초기화
    //     answer_c = 0 ;
    //     //다음 퀴즈로넘어가도록 퀴즈번호를 업
    //     quiz++;
    //     //카운트가 다되어서 문제를 넘어갈 때
    //     if (countdown == 1000) {
    //         socket.emit('mid_result',quiz);
    //         countdown = 10000;
    //         console.log('time end add', quiz);
    //     }
    //     //문제를 다풀어서 넘어갈 때
    //         if(data == 0) {
    //             quiz = 0;
    //             socket.emit('nextok', quiz);
    //             countdown = 10000;
    //             console.log('answer_sum add', quiz);
    //         }
    // });
    //
    // socket.on('nextok' , function(data){
    //
    // });




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






