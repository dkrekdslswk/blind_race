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
        var answer_query = "insert into playing_quizs values (1,\"+student_num+\",\"+quizin+\",0,'\"+answer_num+ \"','0')" ;

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

var user_conn = false;
var roomName = '';
var userData = '';
var groupAllStudent = 0;
var request_query = '';


var kim_app = require('express')();
var kim_http = require('http').Server(kim_app);
var kim_io = require('socket.io')(kim_http);

var kim_mysql      = require('mysql');
var kim_dbconfig   = require('./config/database.js');
var kim_connection = kim_mysql.createConnection(kim_dbconfig);
var char_card = [];

/*kim_app.get('/',function (req, res) {
    res.sendFile(__dirname + '../resources/views/main');
});*/


kim_http.listen(8891,function () {
    var groupAllStudent = 0;

    console.log('listening on *: 8891');
});


// socket.on('select character', function (card) {
//
//     for(var i = 0 ; i < card ; i++){
//         char_card[i] = i+1;
//     }
//
//     kim_io.sockets.in(roomName).emit('character number' , char_card);
//
// });


//컬럼 추가
//ALTER TABLE races ADD user_now_num int(10) NOT NULL;

kim_io.on('connection', function(socket){
    console.log('user in');

    socket.on('join to raceroom',function (room) {
        userData = room.userID;
        roomName = room.raceName;
        groupAllStudent = room.groupStudentCount;
        user_conn = true;

        //소켓 방 조인하기
        socket.join(roomName);
        console.log('join to race room : '+ roomName);

        //유저 정보 전송
        kim_io.sockets.in(roomName).emit('user connected',userData);
        console.log('send to userData : '+ userData );

        //DB 현재 인원수 쿼리해서 추가하기
        request_query = "select count(*) " + " user_num " + " from " + " race_results ";
        kim_connection.query(request_query, function(err, rows) {
            if(err){ throw err; }
            else{
                var race_now_users = rows[0].user_num;
                //현재 인원수 1 추가하기
                var race_new_users = race_now_users + 1;

                //1추가한 현재 인원수 보내기
                kim_io.sockets.in(roomName).emit('now all user',race_new_users);

                //race DB에 1추가된 현재 인원수로 업데이트
                request_query = "UPDATE " + " race_results " + " SET " + " user_num " + " = " + race_new_users + " WHERE " + " user_num " + " = '" + race_now_users + "'";
                kim_connection.query(request_query,function (err, rows) {
                    if(err){ throw err;}
                });
            }
        });

    });

    socket.on('disconnect', function(){
        console.log(userData + 'user disconnected');

        //나간 유저의 정보를 전송
        kim_io.sockets.in(roomName).emit('user disconnected',userData);
        console.log('send to userData : '+ userData );

        //DB 현재 인원수 쿼리해서 감소시키기
        request_query = "select count(*) " + " user_num " + " from " + " race_results ";
        kim_connection.query(request_query, function(err, rows) {
            if(err){ throw err; }
            else{
                var race_now_users = rows[0].user_num;
                //현재 인원수 1 감소하기
                var race_new_users = race_now_users - 1;

                //1감소한 현재 인원수 보내기
                kim_io.sockets.in(roomName).emit('now all user',race_new_users);

                //race DB에 1감소된 현재 인원수로 업데이트
                request_query = "UPDATE " + " race_results " + " SET " + " user_num " + " = " + race_new_users + " WHERE " + " user_num " + " = '" + race_now_users + "'";
                kim_connection.query(request_query,function (err, rows) {
                    if(err){ throw err;}
                });
            }
        });
    });

});