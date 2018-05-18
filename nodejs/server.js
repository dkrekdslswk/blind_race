
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
    var countdown = 30000;
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

    socket.on('android_join_check',function(join_boolean , sessionId ,raceType){
        console.log(join_boolean+","+sessionId);
        io.sockets.emit('android_join_result',join_boolean,sessionId , raceType);
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

    socket.on('pop_quiz_start',function(roomPin,quizData,listName){
        console.log('PopQuiz시작',roomPin+","+quizData)
        io.sockets.in(roomPin).emit('pop_quiz_start',quizData,listName);
    });

    socket.on('pop_quiz_status',function(roomPin){
        console.log('쪽지시험 끝남 ++');
        io.sockets.in(roomPin).emit('pop_quiz_status',roomPin);
    });


    //웹 학생 접속성공여부
    socket.on('web_enter_room',function(roomPin,listName,quizCount,groupName,groupStudentCount, sessionId,enter_check){
        io.sockets.in(roomPin).emit('web_enter_room',listName,quizCount,groupName,groupStudentCount, sessionId,enter_check);
    });

    socket.on('android_game_start',function(roomPin, quizId ,makeType){
        io.sockets.in(roomPin).emit('android_game_start', quizId , makeType);
        console.log("안드스타트",quizId+","+makeType);
    });

    //안드로이드에서 다음 퀴즈로 간다는 것을 전달하기 위한 함수
    socket.on('android_mid_result',function(roomPin, quizId ,makeType ,ranking ){
        io.sockets.in(roomPin).emit('android_mid_result',quizId, makeType, ranking);
        console.log("안드 중간결과 ", quizId +","+ makeType+","+ranking);
    });

    socket.on('race_mid_correct',function(roomPin,correct){
        io.sockets.in(roomPin).emit('race_mid_correct',correct);
    });

    socket.on('android_next_quiz',function(roomPin){
        io.sockets.in(roomPin).emit('android_next_quiz',roomPin);
        console.log("안드로이드 다음문제 " );
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

        countdown = 30000;
        clearInterval(Timer);

        io.sockets.in(roomPin).emit('mid_ranking' ,quiz);
        console.log("퀴즈타입",makeType+","+quiz);
        io.sockets.in(roomPin).emit('nextok',quiz ,makeType);
    });


//퀴즈 답받는 소켓 함수
    socket.on('answer', function(roomPin , answer_num , student_num , nickname , quizId){

        io.sockets.in(roomPin).emit('answer-sum',answer_num,student_num ,quizId);
        console.log("답한 퀴즈  =",quizId+":"+answer_num);
    });


    socket.on('race_ending',function(roomPin){
        clearInterval(Timer);
        io.sockets.in(roomPin).emit('race_ending',roomPin);
    });

    socket.on('race_result',function(roomPin, race_result){
        io.sockets.in(roomPin).emit('race_result',race_result);
    });

});

server.listen(8890, function(){ //4
    console.log('server on!');
});











