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
    console.log('connected',name);


    socket.on('android_nextkey',function(data){
        io.sockets.emit('android_nextquiz','미정');
    });

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
        clearInterval(Timer);
        answer_c = 0 ;


        var answer_checking_query = "select count(case when result='1' then 1 end) o, count(case when result!='1' then 1 end) x from playing_quizs where set_exam_num=1 and sequence="+quiz;
        connection.query(answer_checking_query, function(err, rows) {

            if(err) throw err;
            console.log('The solution is: ', rows);
            var query_result = JSON.stringify(rows);

            io.sockets.emit('right_checked' ,query_result , quiz);
            console.log('right?', query_result);

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
            if(err) throw err;
            console.log('The solution is: ', rows);
        });
        answer_c++;
        io.sockets.emit('answer-sum',answer_c);
        console.log('answer counting: ', answer_c);
    });



});

server.listen(8890, function(){ //4
    console.log('server on!');
});

/*kimseungmok**********************6***************/


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


/*kim_app.get('/',function (req, res) {
    res.sendFile(__dirname + '../resources/views/main');
});*/

kim_io.on('connection', function(socket){
    console.log('user in');
    var roomNum = null;
    race_StudentCount++;

    socket.on('join',function (raceNumber) {
        console.log('join to room');

        roomNum = raceNumber;

        socket.join(raceNumber);
    });

    socket.on('message', function (data) {

        kim_io.sockets.in(roomNum).emit('racenav data',racenav);

        //유저 정보 전송
        kim_io.sockets.in(roomNum).emit('user data',user);

        //현재 접속자 수
        kim_io.sockets.in(roomNum).emit('now user counting',race_StudentCount);
    });


    socket.on('disconnect', function(){

        user_conn = false;
        race_StudentCount--;

        console.log('user out');

        //나간 유저의 정보를 전송
        kim_io.sockets.in(roomNum).emit('disc user',user);

        //현재 접속자 수
        kim_io.sockets.in(roomNum).emit('now user counting',race_StudentCount);

    });
});

kim_http.listen(8891,function () {
    console.log('listening on *: 8891');

});