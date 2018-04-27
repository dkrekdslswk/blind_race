
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

        .counting{
            text-align: center;
        }

        .counting span {
            padding: 10px 20px 10px 20px;
            background-color: white;
        }

        .waitingTable {
            margin-top: 20px;
            margin-left: 2%;
            margin-right: 2%;
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


            $('#room_name').html(roomPin);
            socket.emit('join', roomPin);

            socket.on('user_in',function(roomPin,nick,sessionId,characterId){
                //유저정보를 DB세션에 추가함
                // $.ajax({
                //     type: 'POST',
                //     url: "{{url('/fuck')}}",
                //     dataType: 'json',
                //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                //     data: pin,nickname,session_id,character_num,
                //     success: function (result) {
                //         console.log(result);
                //     },
                //     error: function(request, status, error) {
                //         alert("AJAX 에러입니다. ");
                //     }
                // });

                $('<li class="user_in_room" id="'+ user_num +'"><h4 style="text-align:center; color:white; background-color:black;">' + nickname + '</h4><img src="/img/character/char'+character_num+'.png"></img></li>').appendTo('body');
                quiz_member++;
                $('#student_count').html(quiz_member);
            });

            socket.on('leaveRoom', function(user_num){
                $('#'+user_num).remove();
            })
            //  document.getElementById('start_btn').onclick = function() {

            //  };
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

            var Mid_result_Timer;

            var socket = io(':8890'); //14
            socket.emit('join', roomPin);
            // $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');
            socket.emit('android_game_start',roomPin);

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


            //var quiz_JSON = JSON.parse('<?php //echo json_encode($json['quizData']); ?>');
            var quiz_JSON = [
                {"quiz_num":"1", "name":"아",　"answer1":"あ", "answer2":"い",	"answer3":"い","answer4":"お"},
                {"quiz_num":"2", "name":"카",　"answer1":"か", "answer2":"き",	"answer3":"く","answer4":"け"},
                {"quiz_num":"3", "name":"사","answer1":"さ", "answer2":"し",	"answer3":"す","answer4":"せ"},
                {"quiz_num":"4", "name":"타","answer1":"た", "answer2":"ち",	"answer3":"つ","answer4":"て"},
                {"quiz_num":"5", "name":"5い","answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"}
            ];



            socket.emit('count','1',roomPin);

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

                ranking_process(ranking_j);

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
                socket.emit('android_nextkey',roomPin, quiz_numbar);

            });


            socket.on('timer', function (data) {

                var counting = data/1000;
                document.getElementById('counter').innerText= counting;

                document.getElementById("progressBar")
                    .value = 30 - counting;
                if (timeleft == 0)
                    timeleft = 30;


                if(counting == 0 )
                    socket.emit('count_off',quiz_numbar);
            });

            //상탄 타임 게이지 바


            var x = document.getElementById("mondai-content");
            var A1 = document.getElementById("answer1");
            var A2 = document.getElementById("answer2");
            var A3 = document.getElementById("answer3");
            var A4 = document.getElementById("answer4");


            socket.on('answer-sum', function(data){
                answer_count++;
                document.getElementById('answer_c').innerText= answer_count;
                if(answer_count == quiz_member)
                {
                    socket.emit('count_off',quiz_numbar);
                    document.getElementById('answer_c').innerText="Answers";
                }
            });

            socket.on('nextok',function(data){
                answer_count = 0 ;
                quiz_numbar++;
                if(quiz_JSON.length == data){
                    setTimeout(function(){ location.href="/race_result"; }, 1000);
                }
                else{
                    x.innerText  = quiz_JSON[data].name ;
                    A1.innerText = quiz_JSON[data].answer1;
                    A2.innerText = quiz_JSON[data].answer2;
                    A3.innerText = quiz_JSON[data].answer3;
                    A4.innerText = quiz_JSON[data].answer4;

                }
            });
        };
    </script>
</head>
<body>
<?php //print_r($json['quizData'][0]['quiz_num']); ?>
<?php //echo json_encode($json['quizData']); ?>


<div id="wait_room">
    <div class="student">


        <!--<form action="">-->
        <button onclick="btn_click();" id="start_btn" class="btn btn-lg btn-primary" style="">시작하기</button>
        <!--</form>-->
        <div id="room_name" class="counting">

        </div>
        <br><br>

        <div class="counting">
            <span id="student_count" > 학생 수</span>
        </div>

    </div>


    <ul id="messages"></ul>


    <div class="waitingTable">
        <table class="table table-bordered" id="characterTable" style="text-align: center;">

        </table>
    </div>
</div>
<div id="playing_contents" style="display:none;">
    @include('Race.race_content')
</div>

</body>
</html>