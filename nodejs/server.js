
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
    var countdown = 3000;
    var group_num ="";

    //대기방 참가 (인수 room : 참가하려는 방의 이름 )
    socket.on('join',function (room) {
        socket.join(room);
        console.log('join',room);
        // group_num = room;
    });

    socket.on('android_join',function(roomPin , sessionId){
        io.sockets.emit('android_join',roomPin,sessionId);
        console.log('안드조인',roomPin+","+sessionId);
    });

    socket.on('android_join_check',function(join_boolean , sessionId){
        console.log(join_boolean+","+sessionId);
        io.sockets.emit('android_join_result',join_boolean,sessionId);
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
    socket.on('android_nextkey',function(roomPin, quizId ,makeType ){
        io.sockets.in(roomPin).emit('android_nextX_quiz',quizId, makeType);
    });
    socket.on('android_game_start',function(roomPin, quizId ,makeType){
        io.sockets.in(roomPin).emit('android_game_start', quizId , makeType);
        console.log("안드스타트",roomPin+","+makeType);
    });

    socket.on('android_enter_room',function(roomPin , check , session_id){
        io.sockets.in(roomPin).emit('android_enter_room',roomPin,check,session_id);
    });


    // 타이머 시작함수
    socket.on('count',function(data,group_num,makeType){

        Timer = setInterval(function () {
            countdown -= 1000;
            io.sockets.in(group_num).emit('timer',countdown);
        }, 1000);
        console.log('타임온',group_num);
        if( data == '1'){
            io.sockets.in(group_num).emit('nextok',0,makeType);
        }
    });


    //다음문제로 넘어가기전 Timer를 취소하는 함수
    socket.on('count_off', function(quiz , roomPin , makeType){
        console.log('group_num',roomPin)

        countdown = 3000;
        clearInterval(Timer);

        io.sockets.in(roomPin).emit('mid_ranking' ,quiz);
        console.log("퀴즈타입",makeType+","+quiz);
        io.sockets.in(roomPin).emit('nextok',quiz ,makeType);
    });


//퀴즈 답받는 소켓 함수
    socket.on('answer', function(roomPin , answer_num , student_num , nickname){
        console.log('roomPin',roomPin);
        console.log('Client Send Data:', answer_num);
        console.log('stu',student_num);
        console.log('nickname',nickname);
        console.log('답찍을때 퀴즈',quiz)


        io.sockets.in(roomPin).emit('answer-sum',answer_num,student_num);

        console.log('answer counting: ', answer_num);
    });


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











