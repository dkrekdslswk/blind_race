
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

        console.log('로그인 쿼리전달완료');
//   var row = JSON.parse(rows);
        res.send(rows);
    });
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

io.on('connection', function (socket){
    var TimerOn = false;
    var Timer ;
    var countdown = 10000;
    var group_num ="";

    //대기방 참가 (인수 room : 참가하려는 방의 이름 )
    socket.on('join',function (room) {
        socket.join(room);
        console.log('join',room);
        // group_num = room;
    });
    // 대기방 이탈
    socket.on('leaveRoom', function( group_num, user_num){
        // io.sockets.in(group_num).emit('leaveRoom',user_num);
        console.log('danger', group_num+","+user_num);
    });

    //대기방 인원 추가
    socket.on('user_in',function(pin,nickname,session_id,character_num){
        console.log('유저참가', '핀번호:'+pin+'등록번호:'+session_id+'닉네임'+nickname+'캐릭터번호:'+character_num);
        io.sockets.in(pin).emit('user_in',pin,nickname,session_id,character_num);
    });


    //안드로이드에서 다음 퀴즈로 간다는 것을 전달하기 위한 함수
    socket.on('android_nextkey',function(group_key, quiz ){
        io.sockets.in(group_num).emit('android_nextquiz',quiz);
    });
    socket.on('android_game_start',function(group_key){
        io.sockets.in(group_key).emit('android_game_start',1);
    });

    // 타이머 시작함수
    socket.on('count',function(data,group_num){

        Timer = setInterval(function () {
            countdown -= 1000;
            io.sockets.in(group_num).emit('timer',countdown);
        }, 1000);
        console.log('타임온',group_num);
        if( data == '1'){
            // quiz = 0 ;
            io.sockets.in(group_num).emit('nextok',0);
            // io.sockets.in(group_num).emit('entrance_ranking' ,query_result);
        }
    });


    //다음문제로 넘어가기전 Timer를 취소하는 함수
    // socket.on('count_off', function(quiz){
    //     console.log('group_num',group_num)
    //     // quiz++;

    //     countdown = 10000;
    //     clearInterval(Timer);
    //     answer_c = 0 ;


    //     var answer_checking_query = "select count(case when result='1' then 1 end) o, count(case when result!='1' then 1 end) x from playing_quizs where set_exam_num=1 and sequence="+quiz;
    //     connection.query(answer_checking_query, function(err, rows) {

    //         if(err) throw err;

    //         console.log('순위결정쿼리: ', rows);
    //         var query_result = JSON.stringify(rows);

    //         io.sockets.in(group_num).emit('right_checked' ,query_result , quiz);
    //         console.log('퀴즈몇번??', quiz);

    //     });

    //     var ranking_query = "select p.user_num user_num , user_nick nickname, IFNULL(count(case when result ='1' then 1 end), 0) point, s.character_num character_num "
    //         +"from playing_quizs p join sessions s on p.user_num = s.user_num "
    //         +"where p.set_exam_num='1'"
    //         +"group by user_num "
    //         +"order by point desc";

    //     connection.query(ranking_query, function(err, rows) {

    //         if(err) throw err;
    //         console.log('The solution is: ', rows);
    //         var query_result = JSON.stringify(rows);

    //         io.sockets.in(group_num).emit('mid_ranking' ,query_result);

    //     });
    //     io.sockets.in(group_num).emit('nextok',quiz);
    // });


//퀴즈 답받는 소켓 함수
    // socket.on('answer', function(answer_num , student_num , nickname ,quiz){
    //     console.log('Client Send Data:', answer_num);
    //     console.log('stu',student_num);
    //     console.log('nickname',nickname);
    //     // var quizin = quiz+1;
    //     console.log('답찍을때 퀴즈',quiz)

    //     // 문제리스트번호, 학생등록번호, 퀴즈 몇번문제, 재시험여부(0,1) , 몇번골랐는지 , '오답노트'
    //     if(answer_num == 0)
    //         quiz = 0;


    //     var answer_query = "insert into playing_quizs values (1,"+student_num+","+quiz+",0,'"+answer_num+ "','0')" ;

    //     console.log('user',count);

    //     connection.query(answer_query, function(err, rows) {
    //         if(err) {
    //             console.log('문제저장쿼리오류 ',"학생번호"+student_num+",퀴즈번호"+quiz+",정답번호"+answer_num);
    //             // throw err;
    //         }
    //         console.log('문제답안저장쿼리: ', rows);
    //     });

    //     if(answer_num != 0 )
    //         io.sockets.in(group_num).emit('answer-sum',answer_c);

    //     console.log('answer counting: ', answer_c);
    // });


    // socket.on('race_ending',function(data){
    //     clearInterval(Timer);

    //     var ranking_query = "select p.user_num user_num , user_nick nickname, IFNULL(count(case when result ='1' then 1 end), 0) point, s.character_num character_num "
    //         +"from playing_quizs p join sessions s on p.user_num = s.user_num "
    //         +"where p.set_exam_num='1' "
    //         +"group by user_num "
    //         +"order by point desc";

    //     connection.query(ranking_query, function(err, rows) {

    //         if(err) throw err;
    //         console.log('엔딩쿼리: ', rows);
    //         var query_result = JSON.stringify(rows);
    //         io.sockets.emit('race_ending',query_result);
    //         // io.sockets.in(group_num).emit('race_ending', query_result);
    //     });

    //     var delete_session_query = "delete from sessions where user_num <> 1;"
    //     connection.query(delete_session_query, function(err, rows) {if(!err) console.log('삭제','세션'); });

    //     // var delete_quizs_query = "delete from playing_quizs where set_exam_num= 1;"
    //     // connection.query(delete_quizs_query, function(err, rows) {if(!err) console.log('삭제','퀴즈'); });


    // });


});

server.listen(8890, function(){ //4
    console.log('server on!');
});











