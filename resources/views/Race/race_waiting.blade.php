
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Waiting Room</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">


    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <script type="text/javascript"></script>

    <style>
        #wait_room_nav{
            box-shadow:  60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
            /*background-color: rgba(255,255,255,.84);*/
            background-color:white;
            width: 100%;
            height: 100px;
            border-radius: 10px;
            font-weight:bold;
            font-size:50px;
        }

        .user_in_room{
            display:inline-block;

            margin-right:50px;
            border-radius: 15px 50px 30px;
        }
        .student {
            margin-top: 3%;
            display: block;
            text-align: right;
        }

        .student form{
            display: inline;
            background-color: white;
            margin-right: 1%;
        }
        #counting_student{
            text-align:center;
            font-size:30px;
            position:absolute;
            left:5%;
        }

        .counting{
            text-align: center;
        }

        .counting span {
            padding: 10px 20px 10px 20px;
            background-color: white;
            position:absolute;
            left: 10%;
        }

        .waitingTable {
            margin-top: 20px;
            margin-left: 2%;
            margin-right: 2%;
        }
        #room_Pin{
            background-color:white;
            width: 35%;
            height: 100px;
            font-size:70px;
            margin:auto;
        }

        #messages { list-style-type: none; }
        #messages li { padding: 5px 10px; }

    </style>
    <script>
        var quiz_numbar = 0;
        var quiz_member = 0;
        var answer_count = 0;
        var roomPin =0;

        window.onload = function() {
            var socket = io(':8890');

            var groupId  = 1;
            var raceType = 'race';
            var listId = 1;

            $.ajax({
                type: 'POST',
                url: "{{url('/raceController/createRace')}}",
                async:false,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: "groupId="+groupId+"&raceType="+raceType+"&listId="+listId,
                success: function (result) {
                    console.log(result['roomPin']);
                    roomPin = result['roomPin'];
                },
                error: function(request, status, error) {
                    alert("AJAX 밖에것 에러입니다. ");
                }
            });


            $('#room_Pin').html("PIN:"+roomPin);
            socket.emit('join', roomPin);

            socket.on('user_in',function(roomPin,nick,sessionId,characterId){
                //유저정보를 DB세션에 추가함
                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/studentIn')}}",
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"roomPin="+roomPin+"&nick="+nick+"&sessionId="+sessionId+"&characterId="+characterId,
                    success: function (result) {
                        console.log(result['nickCheck']);
                        if( result['nickCheck'] && result['characterCheck'] )
                        {
                            //정상작동
                            $('<li class="user_in_room" id="'+ sessionId +'"><h4 style="text-align:center; color:white; background-color:black;">' + nick + '</h4><img src="/img/character/char'+characterId+'.png"></img></li>').appendTo('body');

                            quiz_member++;
                            $('#student_count').html(quiz_member);
                            //유저한테 다시보내줌 result['characterId'];
                            socket.emit('android_enter_room',roomPin, result['characterId'], sessionId);
                        }
                        else{
                            //닉네임이나 캐릭터가 문제있음
                            socket.emit('android_enter_room',roomPin, false, sessionId);
                        }

                    },
                    error: function(request, status, error) {
                        alert("AJAX 에러입니다. ");
                    }
                });
            });

            socket.on('leaveRoom', function(user_num){
                $('#'+user_num).remove();
            })
        };

        //순위 변동 함수 정의
        function ranking_process(ranking_j){
            var ranking_JSON = JSON.parse(ranking_j);

            var changehtml = "";

            for(var i=0;  i <ranking_JSON.length; i++){

                var rank = i+1;

                changehtml +='<li data-toggle="collapse" data-target="#products" class="box collapsed active "';
                switch(i){
                    case 0: changehtml += 'style="background-color:gold;"><img src="https://i.imgur.com/guhQqnS.png" width="40px" alt=""/>'; break;
                    case 1: changehtml += 'style="background-color:silver;"><img src="https://i.imgur.com/KARrYZA.png" width="40px" alt=""/>'; break;
                    case 2: changehtml += 'style="background-color:saddlebrown;"><img src="https://i.imgur.com/ageVYAE.png" width="40px" alt=""/>'; break;
                    default : changehtml += '>';
                }
                changehtml+=
                    +rank
                    +" 등"
                    + ranking_JSON[i].nickname
                    +'<i class="magin fas fa-trophy"></i><span >'
                    + ranking_JSON[i].point*100
                    +" point"
                    +'</span><i class="margin"><img src="/img/character/char'
                    +ranking_JSON[i].character_num
                    +'.png" width="60px">'
                    +'</i></a>'
                    +'</li>' ;
            }
            $(".nav-side-menu").html(changehtml);
        }


        function btn_click(){
            //var quiz_JSON = JSON.parse('<?php //echo json_encode($json['quizData']); ?>');
            var quiz_JSON = [
                {"quizCount":"1", "question":"아",　"right":"あ", "example1":"い",	"example2":"い","example3":"お","quizId":"5","quizType":"vocabulary","makeType":"obj","hint":""},
                {"quizCount":"2", "question":"카",　"right":"か", "example1":"き",	"example2":"く","example3":"け","quizId":"4","quizType":"word","makeType":"sub","hint":""},
                {"quizCount":"3", "question":"사","right":"さ", "example1":"し",	"example2":"す","example3":"せ","quizId":"3","quizType":"grammar","makeType":"obj","hint":""},
                {"quizCount":"4", "question":"타","right":"た", "example1":"ち",	"example2":"つ","example3":"て","quizId":"2","quizType":"vocabulary","makeType":"sub","hint":""},
                {"quizCount":"5", "question":"5い","right":"はい", "example1":"いいえ",	"example2":"分からない","example3":"分かる","quizId":"1","quizType":"word","makeType":"obj","hint":""}
            ];

            var Mid_result_Timer;

            var socket = io(':8890'); //14
            socket.emit('join', roomPin);
            // $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');
            socket.emit('android_game_start',roomPin,quiz_JSON[0].makeType);

            //대기방에 입장된 캐릭터와 닉네임이 없어짐
            $('.user_in_room').remove();


            //입장순위표 만들 ajax구문
            //  $.ajax({
            //             type: 'POST',
            //             url: "{{url('/fuck')}}",
            //             dataType: 'json',
            //             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //             data: nickname,user_num,character_num,
            //             success: function (result) {
            //                ranking_process(result);
            //             },
            //             error: function(request, status, error) {
            //                 alert("AJAX 에러입니다. ");
            //             }
            // });

            socket.on('entrance_ranking', function(ranking_j){
                ranking_process(ranking_j);
            });

            $('#wait_room').hide();
            $('#playing_contents').show();
            //아아아
            var timeleft = 20;






            socket.emit('count','1',roomPin , quiz_JSON[0].makeType);

            socket.on('right_checked' ,function(data , quiz_num){
                var right_checking_JSON = JSON.parse(data);
                var correct_count = right_checking_JSON[0].o;
                var incorrect_count = right_checking_JSON[0].x;

                if(correct_count == 0)
                    incorrect_count = 1 ;

                $("#quiz_number").text(quiz_num);

                $("#winners").text(correct_count+"명 정답!");

                $("#right").text(correct_count);
                $("#wrong").text(incorrect_count);

                var correct_percentage =Math.floor(correct_count / (correct_count + incorrect_count) * 100);

                // $('.pie::before').css('content',correct_percentage);

                --quiz_num;

                $("#Mid_Q_Name").text(quiz_JSON[quiz_num].name);
                $("#Mid_A_Right").text(correct_percentage+"%정답 / "+quiz_JSON[quiz_num].answer1);

                function sliceSize(dataNum, dataTotal) {
                    return (dataNum / dataTotal) * 360;
                }
                function addSlice(sliceSize, pieElement, offset, sliceID, color) {
                    $(pieElement).append(
                        "<div class='slice " + sliceID + "'><span></span></div>"
                    );
                    var offset = offset - 1;
                    var sizeRotation = -179 + sliceSize;
                    $("." + sliceID).css({
                        "transform": "rotate(" + offset + "deg) translate3d(0,0,0)"
                    });
                    $("." + sliceID + " span").css({
                        "transform": "rotate(" + sizeRotation + "deg) translate3d(0,0,0)",
                        "background-color": color
                    });

                }
                function iterateSlices(
                    sliceSize,
                    pieElement,
                    offset,
                    dataCount,
                    sliceCount,
                    color
                ) {
                    var sliceID = "s" + dataCount + "-" + sliceCount;
                    var maxSize = 179;
                    if (sliceSize <= maxSize) {
                        addSlice(sliceSize, pieElement, offset, sliceID, color);
                    } else {
                        addSlice(maxSize, pieElement, offset, sliceID, color);
                        iterateSlices(
                            sliceSize - maxSize,
                            pieElement,
                            offset + maxSize,
                            dataCount,
                            sliceCount + 1,
                            color
                        );
                    }
                }
                function createPie(dataElement, pieElement) {
                    var listData = [];
                    $(dataElement + " span").each(function () {
                        listData.push(Number($(this).html()));
                    });
                    var listTotal = 0;
                    for (var i = 0; i < listData.length; i++) {
                        listTotal += listData[i];
                    }
                    var offset = 0;
                    var color = [
                        "green",
                        "silver",
                        "orange",
                        "tomato",
                        "crimson",
                        "purple",
                        "turquoise",
                        "forestgreen",
                        "navy",
                        "gray"
                    ];
                    for (var i = 0; i < listData.length; i++) {
                        var size = sliceSize(listData[i], listTotal);
                        iterateSlices(size, pieElement, offset, i, 0, color[i]);
                        $(dataElement + " li:nth-child(" + (
                            i + 1
                        ) + ")").css("border-color", color[i]);
                        offset += size;
                    }
                }
                createPie(".pieID.legend", ".pieID.pie");
            });


            socket.on('mid_ranking',function(ranking_j){

                document.getElementById('counter').innerText= " ";
                $("#content").hide();
                document.getElementById('answer_c').innerText= "Answers";

                // ranking_process(ranking_j);

                $('#play_bgm').remove();

                // $('<audio id="mid_result_bgm" autoplay><source src="/bgm/mid_result.mp3"></audio>').appendTo('body');

                $("#mid_result").show();

                Mid_result_Timer = setTimeout(function(){
                    $('#mid_result_bgm').remove();
                    socket.emit('count','time on',roomPin);

                    $("#content").show();
                    // $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');
                    $("#mid_result").hide();
                    socket.emit('android_nextkey',roomPin, quiz_numbar);

                }, 30000);
            });


            $("#Mid_skip_btn").click(function(){

                clearTimeout(Mid_result_Timer);

                $('#mid_result_bgm').remove();
                socket.emit('count','time on',roomPin);


                $("#content").show();
                // $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');

                $("#mid_result").hide();
                socket.emit('android_nextkey',roomPin, quiz_numbar , quiz_JSON[quiz_numbar-1].makeType);

            });


            socket.on('timer', function (data) {

                var counting = data/1000;
                document.getElementById('counter').innerText= counting;

                document.getElementById("progressBar")
                    .value = 30 - counting;
                if (timeleft == 0)
                    timeleft = 30;


                if(counting == 0 )
                    socket.emit('count_off',quiz_numbar , roomPin , quiz_JSON[quiz_numbar-1].makeType);
            });

            //상탄 타임 게이지 바


            var x = document.getElementById("mondai-content");
            var A1 = document.getElementById("answer1");
            var A2 = document.getElementById("answer2");
            var A3 = document.getElementById("answer3");
            var A4 = document.getElementById("answer4");


            socket.on('answer-sum', function(answer ,sessionId){

                  $.ajax({
                             type: 'POST',
                             url: "{{url('/fuck')}}",
                             dataType: 'json',
                             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                             data:"roomPin="+roomPin+"&answer="+answer+"&sessionId="+sessionId+"&quizId="+quiz_JSON[quiz_numbar-1].quizId,
                             success: function (result) {
                                 answer_count++;
                                 document.getElementById('answer_c').innerText= answer_count;
                             },
                             error: function(request, status, error) {
                                 alert("AJAX 에러입니다. ");
                             }
                 });

                if(answer_count == quiz_member)
                {
                    socket.emit('count_off',quiz_numbar);
                    document.getElementById('answer_c').innerText="Answers";
                }
            });

            socket.on('nextok',function(data, makeType){
                answer_count = 0 ;
                quiz_numbar++;
                if(quiz_JSON.length == data){
                    setTimeout(function(){ location.href="/race_result"; }, 1000);
                }
                else{
                    x.innerText  = quiz_JSON[data].question ;
                    switch(makeType){
                        case "obj" :
                            A1.innerText = quiz_JSON[data].right;
                            A2.innerText = quiz_JSON[data].example1;
                            A3.innerText = quiz_JSON[data].example2;
                            A4.innerText = quiz_JSON[data].example3;
                            $(".row").show();
                            break;
                        case "sub" :
                            $(".row").hide();
                            break;
                    }
                }

            });
        };
    </script>
</head>
<body>
<?php //print_r($json['quizData'][0]['quiz_num']); ?>
<?php //echo json_encode($json['quizData']); ?>


<div id="wait_room_nav" class="inline-class">
    <img  class="inline-class" src="/img/blind_race.png" width="100" height="100">

    <span  id="race_name"  style="position: absolute;  left:40%; top:2%;">레이스 제목 </span>
    <span  id="race_count" style="position: absolute;  right:15%; top:4%; font-size:30px" > 문제수 </span>
    <span  id="group_name" style="font-size:30px;"> 그룹이름 </span>
    <span id="group_student_count" style="font-size:30px; position: absolute;  right: 0; top:4%;">학생 총 수</span>

</div>


<div id="wait_room">
    <div class="student">


        <!--<form action="">-->
        <button onclick="btn_click();" id="start_btn" class="btn btn-lg btn-primary" style="">시작하기</button>
        <!--</form>-->

            <div id="room_Pin" class="counting">
            </div>

        <div id="counting_student">
            <span id="student_count" > 학생 수</span>
        </div>

    </div>


    <ul id="messages"></ul>


    <div class="waitingTable">
        <table class="table table-bordered" id="characterTable" style="text-align: center;">

        </table>
    </div>

    <div id="guide_footer" style="position:absolute; bottom:0; background-color:lightgreen; width:100%; height:10%; color:white; font-size:40px; line-height:100px;">
        <img src="/img/info.png" style="width:50px; height:50px;" alt="">학생들이 다 들어오면 시작하기를 눌러주세요
    </div>
</div>
<div id="playing_contents" style="display:none;">
    @include('Race.race_content')
</div>


</body>
</html>