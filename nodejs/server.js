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

var TimerOn = false;
var Timer ;


io.on('connection', function (socket){
    var name = "user" + count++;
    var roomName = '';
    var userData = '';
    var race_allUser = 0;

    //대기방 참가
    socket.on('join',function (room) {
        socket.join(room);
        console.log('join',room);
    });

    // 대기방 이탈
    socket.on('leaveRoom', function( group_num, user_num){
        io.sockets.in(group_num).emit('leaveRoom',user_num);

        var leaveRoom_Query = "DELETE FROM race_results WHERE set_exam_num = 1 AND user_num = "+user_num;
        connection.query(leaveRoom_Query, function(err, rows) {if(err){ throw err; } else{ console.log('user',user_num+'퇴장'); }   });

        socket.leave(group_num);
    });


    //대기방 인원참가
    socket.on('user_in',function(group_num , nickname , user_num){
        //DB 현재 인원수 쿼리해서 추가하기
        var add_user_query = "INSERT INTO race_results (set_exam_num, user_num, race_score, team_num, created_at) VALUES ('1', ' "+user_num+" ', '0', NULL, CURRENT_TIMESTAMP);";
        connection.query(add_user_query, function(err, rows) {  if(err){ throw err; } else{ console.log('user',user_num+'입장'); }  });


        io.sockets.in(group_num).emit('user_in',nickname , user_num);
        console.log('group_num' ,nickname);


    });

    socket.on('android_nextkey',function(data){
        io.sockets.emit('android_nextquiz','미정');
    });

    // 타이머 시작함수
    socket.on('count',function(data,group_num){

        Timer = setInterval(function () {
            countdown -= 1000;
            io.sockets.in(group_num).emit('timer',countdown);
        }, 1000);
        console.log('타임온',group_num);
        if( data == '1')
            quiz = 0 ; io.sockets.in(group_num).emit('nextok',quiz);
    });



    socket.on('count_off', function(data){
        quiz++;
        countdown = 10000;
        clearInterval(Timer);
        answer_c = 0 ;


        var answer_checking_query = "select count(case when result='1' then 1 end) o, count(case when result!='1' then 1 end) x from playing_quizs where set_exam_num=1 and sequence="+quiz;
        connection.query(answer_checking_query, function(err, rows) {

            if(err) throw err;
            console.log('The solution is: ', rows);
            var query_result = JSON.stringify(rows);

            io.sockets.emit('right_checked' ,query_result , quiz);
            console.log('right?', quiz);

        });

        var ranking_query = "select user_num , count(result) point from playing_quizs where result='1' and set_exam_num='1'  group by user_num";


        connection.query(ranking_query, function(err, rows) {

            if(err) throw err;
            console.log('The solution is: ', rows);
            var query_result = JSON.stringify(rows);

            io.sockets.emit('mid_ranking' ,query_result);

        });
        socket.emit('nextok',quiz);
    });


//퀴즈 답받는 소켓 함수
    socket.on('answer', function(answer_num , student_num , nickname){
        console.log('Client Send Data:', answer_num);
        var quizin = quiz+1;
        // 문제리스트번호, 학생등록번호, 퀴즈 몇번문제, 재시험여부(0,1) , 몇번골랐는지 , '오답노트'
        var answer_query = "insert into playing_quizs values (1,"+student_num+","+quizin+",0,'"+answer_num+ "','0')" ;
        console.log('user',count);
        connection.query(answer_query, function(err, rows) {
            // if(err) throw err; 값이 이미 있을시 실패함
            console.log('The solution is: ', rows);
        });
        answer_c++;
        io.sockets.emit('answer-sum',answer_c);
        console.log('answer counting: ', answer_c);
    });


    socket.on('race_ending',function(data){


        var ranking_query = "select user_num , count(result) point from playing_quizs where result='1' and set_exam_num='1'  group by user_num";


        connection.query(ranking_query, function(err, rows) {

            if(err) throw err;
            console.log('The solution is: ', rows);
            var query_result = JSON.stringify(rows);

            io.sockets.emit('race_ending', query_result);

        });
    })
});

server.listen(8890, function(){ //4
    console.log('server on!');
});

