<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Waiting Room</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">


    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <script type="text/javascript"></script>

    <style>
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
        var pub_group_num = prompt('방 비밀번호를 입력해주세요','');

        window.onload = function() {
            $('#room_name').html(pub_group_num);
            var socket = io(':8890');


            socket.emit('join', pub_group_num);

            socket.on('user_in',function(nickname , user_num, character_num){
                $('<img src="/img/character/char'+character_num+'.png"></img><li id="'+ user_num +'">' + nickname + '</li>').appendTo('body');
                // $('#student_count').html(student_count);
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
            socket.emit('join', pub_group_num);

            socket.emit('android_game_start',pub_group_num);

            socket.on('entrance_ranking', function(ranking_j){
                ranking_process(ranking_j);
            });

            $('#wait_room').hide();
            $('#playing_contents').show();
            //아아아

            var quiz_number = 0;
            var timeleft = 20;

            var quiz_JSON = [
                {"quiz_num":"1", "name":"苦労してためたお金なのだから、一円（　　）無駄には使いたくない。",　"answer1":"たりとも", "answer2":"ばかりも",	"answer3":"だけさえ","answer4":"とはいえ"},
                {"quiz_num":"2", "name":"この店は洋食と和食の両方が楽しめる（　　）、お得意さんが多い。",　"answer1":"とあって", "answer2":"からして",	"answer3":"にあって","answer4":"にしては"},
                {"quiz_num":"3", "name":"姉は市役所に勤める（　　）、ボランティアで日本語を教えています。","answer1":"かたわら", "answer2":"かたがた",	"answer3":"こととて","answer4":"うちに"},
            ];

            socket.emit('count','1',pub_group_num);

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

                var correct_percentage = correct_count / (correct_count + incorrect_count) * 100;

                // $('.pie::before').css('content',correct_percentage);

                --quiz_num;

                $("#Mid_Q_Name").text(quiz_JSON[quiz_num].name);
                $("#Mid_A_Right").text(quiz_JSON[quiz_num].answer1);

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

                $("#mid_result").show();

                Mid_result_Timer = setTimeout(function(){

                    socket.emit('count','time on',pub_group_num);
                    $("#content").show();
                    $("#mid_result").hide();
                    socket.emit('android_nextkey','미정');

                }, 5000);
            });


            $("#Mid_skip_btn").click(function(){
                clearTimeout(Mid_result_Timer);
                socket.emit('count','time on',pub_group_num);
                $("#content").show();
                $("#mid_result").hide();
                socket.emit('android_nextkey','미정');
            });


            socket.on('timer', function (data) {

                var counting = data/1000;
                document.getElementById('counter').innerText= counting;

                document.getElementById("progressBar")
                    .value = 20 - counting;
                if (timeleft == 0)
                    timeleft = 20;


                if(counting == 0 )
                    socket.emit('count_off','on');
            });

            //상탄 타임 게이지 바


            var x = document.getElementById("mondai-content");
            var A1 = document.getElementById("answer1");
            var A2 = document.getElementById("answer2");
            var A3 = document.getElementById("answer3");
            var A4 = document.getElementById("answer4");


            socket.on('answer-sum', function(data){
                document.getElementById('answer_c').innerText= data;

                if(data == 3)
                {

                    socket.emit('count_off','on');
                    document.getElementById('answer_c').innerText="Answers";
                }
            });

            socket.on('nextok',function(data){

                if(quiz_JSON.length == data){
                    setTimeout(function(){ location.href="/Race_result"; }, 3000);
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
<?php print_r($json); ?>
{{--레이스 네비게이션--}}
<racenav>
    @include('Navigation.mainnav')
</racenav>

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
    @include('Raid.raid')
</div>


</body>
</html>
