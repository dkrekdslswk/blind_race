<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Waiting Room</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <script type="text/javascript">

    </script>

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
        var pub_group_num = '<?php echo $json['group']['groupName']; ?>';

        window.onload = function() {
            var socket = io(':8890');

            
            socket.emit('join', pub_group_num);

            socket.on('user_in',function(user , user_num){
                $('<li id="'+ user_num +'">' + user + '</li>').appendTo('body');
                // $('#student_count').html(student_count);
            });

            socket.on('leaveRoom', function(user_num){
                $('#'+user_num).remove();
            })
            //  document.getElementById('start_btn').onclick = function() {

            //  };
        };
        function btn_click(){

            var Mid_result_Timer;

            $('#wait_room').hide();
            $('#playing_contents').show();
            var socket = io(':8890'); //1
            socket.emit('join', pub_group_num);
            //아아아
            var quiz_number = 0;

            var timeleft = 20;

            var quiz_JSON = [
                {"quiz_num":"1", "name":"아",　"answer1":"あ", "answer2":"い",	"answer3":"い","answer4":"お"},
                {"quiz_num":"2", "name":"카",　"answer1":"か", "answer2":"き",	"answer3":"く","answer4":"け"},
                {"quiz_num":"3", "name":"사","answer1":"さ", "answer2":"し",	"answer3":"す","answer4":"せ"},
                {"quiz_num":"4", "name":"타","answer1":"た", "answer2":"ち",	"answer3":"つ","answer4":"て"},
                {"quiz_num":"5", "name":"하","answer1":"は", "answer2":"ひ",	"answer3":"ふ","answer4":"へ"}
            ];

            socket.emit('count','1',pub_group_num);

            socket.on('right_checked' ,function(data , quiz_num){
                var right_checking_JSON = JSON.parse(data);
                $("#quiz_number").text(quiz_num);
                $("#right").text(right_checking_JSON[0].o);
                $("#wrong").text(right_checking_JSON[0].x);

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
                        "red",
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


            socket.on('mid_ranking',function(data){


                document.getElementById('counter').innerText= " ";
                $("#content").hide();
                document.getElementById('answer_c').innerText= "0/6명(db) 풀이완료";
                var ranking_JSON = JSON.parse(data);
                var changehtml = "";
                for(var i=0;  i <ranking_JSON.length; i++){
                    changehtml+='<a href="#">' + ranking_JSON[i].user_num + "학생" + ranking_JSON[i].point + "개맞춤" + '</a>';
                    // $('<a href="#">' + ranking_JSON[i].user_num + "학생" + ranking_JSON[i].point + "개맞춤" + '</a>').appendTo('.sidenav');
                }
                $(".sidenav").html(changehtml);
                $("#mid_result").show();

                Mid_result_Timer = setTimeout(function(){

                    socket.emit('count','time on',pub_group_num);
                    $("#content").show();
                    $("#mid_result").hide();
                    socket.emit('android_nextkey','미정');

                }, 3000);
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


            var x = document.getElementById("mondai");
            var A1 = document.getElementById("answer1");
            var A2 = document.getElementById("answer2");
            var A3 = document.getElementById("answer3");
            var A4 = document.getElementById("answer4");


            socket.on('answer-sum', function(data){
                document.getElementById('answer_c').innerText= data+ "/6명(db) 풀이완료";

                if(data == 2)
                {

                    socket.emit('count_off','on');
                    document.getElementById('answer_c').innerText= "0/6명(db) 풀이완료";
                }
            });

            socket.on('nextok',function(data){

                if(quiz_JSON.length == data){
                    setTimeout(function(){ location.href="/recordbox"; }, 2900);
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
    @include('Navigation.racenav')
</racenav>

<div id="wait_room">
    <div class="student">

        <!--<form action="">-->
        <button onclick="btn_click();" id="start_btn" class="btn btn-lg btn-primary" style="">시작하기</button>
        <!--</form>-->

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
