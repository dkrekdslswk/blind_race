<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .sidenav {
        width: 130px;
        position: fixed;
        z-index: 1;
        top: 20px;
        left: 10px;
        background: #eee;
        overflow-x: hidden;
        padding: 8px 0;
    }

    .sidenav a {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 10px;
        color: #2196F3;
        display: block;
        margin-right: 10px;
    }
    .sidenav a:hover {
        color: #064579;
    }

    .main {
        margin-left: 230px;
        /* Same width as the sidebar + left position in px */
        font-size: 28px;
        /* Increased text to enable scrolling */
        padding: 0 10px;
    }

    .column {
        float: left;
        width: 25%;
        padding: 20px;
        height: 300px;
        border-radius: 20px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }
        .sidenav a {
            font-size: 18px;
        }
    }
    #mid_result{
        margin-left:160px;
    }
    #counter{
        margin-top:50px;
        color:black;
        width:150px;
        height:150px;
        font-size:50px;
        font-weight:bold;
        line-height:100px;
        border: 20px solid purple;
        border-radius: 50%;
        background-color: rgba(255,255,255,.84);
        position:fixed;
    }
    #mondai{
        margin-left:150px;
        box-shadow:  60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
        background-color: rgba(255,255,255,.84);
        width: 700px;
        height:250px;
        border-radius: 20px;
        font-weight:bold;
        font-size:40;

    }
    .row{
        margin-top:50px;
    }
    .inline-class{
        display:inline-block;
    }
    #mondai-content{

        margin-left:100px;
        line-height: 100px;
    }
    #answer_c{

        margin-left:20px;
        box-shadow:  60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
        background-color: rgba(255,255,255,.84);
        width:250px;
        height:100%;
        border-radius: 20px;
        line-height:300px;
        font-size:40px;
    }
    progress {
        text-align:left;
        width: 300px;
        margin: 2em auto;
        padding: 4px;
        border: 0 none;

        background: silver;
        border-radius: 14px;
        box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
    }
    progress::-webkit-progress-bar {
        background: transparent;
    }
    progress::-webkit-progress-value {
        border-radius: 12px;
        background: #4CAF50;
        box-shadow: inset 0 -2px 4px rgba(0,0,0,0.4), 0 2px 5px 0px rgba(0,0,0,0.3);
    }
</style>

<body id="client">
<script>

    // window.onload = function () {
    //     var socket = io(':8890'); //1
    //     //아아아
    //     var quiz_number = 0;

    //     var timeleft = 20;

    //     var quiz_JSON = [
    //         {"quiz_num":"1", "name":"아",　"answer1":"あ", "answer2":"い",	"answer3":"い","answer4":"お"},
    //         {"quiz_num":"2", "name":"카",　"answer1":"か", "answer2":"き",	"answer3":"く","answer4":"け"},
    //         {"quiz_num":"3", "name":"사","answer1":"さ", "answer2":"し",	"answer3":"す","answer4":"せ"},
    //         {"quiz_num":"4", "name":"타","answer1":"た", "answer2":"ち",	"answer3":"つ","answer4":"て"},
    //         {"quiz_num":"5", "name":"하","answer1":"は", "answer2":"ひ",	"answer3":"ふ","answer4":"へ"}
    //     ];

    //     socket.emit('count','1');

    //     socket.on('right_checked' ,function(data , quiz_num){
    //         var right_checking_JSON = JSON.parse(data);
    //         $("#quiz_number").text(quiz_num);
    //         $("#right").text(right_checking_JSON[0].o);
    //         $("#wrong").text(right_checking_JSON[0].x);

    //         function sliceSize(dataNum, dataTotal) {
    //             return (dataNum / dataTotal) * 360;
    //         }
    //         function addSlice(sliceSize, pieElement, offset, sliceID, color) {
    //             $(pieElement).append(
    //                 "<div class='slice " + sliceID + "'><span></span></div>"
    //             );
    //             var offset = offset - 1;
    //             var sizeRotation = -179 + sliceSize;
    //             $("." + sliceID).css({
    //                 "transform": "rotate(" + offset + "deg) translate3d(0,0,0)"
    //             });
    //             $("." + sliceID + " span").css({
    //                 "transform": "rotate(" + sizeRotation + "deg) translate3d(0,0,0)",
    //                 "background-color": color
    //             });
    //         }
    //         function iterateSlices(
    //             sliceSize,
    //             pieElement,
    //             offset,
    //             dataCount,
    //             sliceCount,
    //             color
    //         ) {
    //             var sliceID = "s" + dataCount + "-" + sliceCount;
    //             var maxSize = 179;
    //             if (sliceSize <= maxSize) {
    //                 addSlice(sliceSize, pieElement, offset, sliceID, color);
    //             } else {
    //                 addSlice(maxSize, pieElement, offset, sliceID, color);
    //                 iterateSlices(
    //                     sliceSize - maxSize,
    //                     pieElement,
    //                     offset + maxSize,
    //                     dataCount,
    //                     sliceCount + 1,
    //                     color
    //                 );
    //             }
    //         }
    //         function createPie(dataElement, pieElement) {
    //             var listData = [];
    //             $(dataElement + " span").each(function () {
    //                 listData.push(Number($(this).html()));
    //             });
    //             var listTotal = 0;
    //             for (var i = 0; i < listData.length; i++) {
    //                 listTotal += listData[i];
    //             }
    //             var offset = 0;
    //             var color = [
    //                 "green",
    //                 "red",
    //                 "orange",
    //                 "tomato",
    //                 "crimson",
    //                 "purple",
    //                 "turquoise",
    //                 "forestgreen",
    //                 "navy",
    //                 "gray"
    //             ];
    //             for (var i = 0; i < listData.length; i++) {
    //                 var size = sliceSize(listData[i], listTotal);
    //                 iterateSlices(size, pieElement, offset, i, 0, color[i]);
    //                 $(dataElement + " li:nth-child(" + (
    //                     i + 1
    //                 ) + ")").css("border-color", color[i]);
    //                 offset += size;
    //             }
    //         }
    //         createPie(".pieID.legend", ".pieID.pie");
    //     });


    //     socket.on('mid_ranking',function(data){
    //         document.getElementById('counter').innerText= " ";
    //         $("#content").hide();
    //         var ranking_JSON = JSON.parse(data);
    //         var changehtml = "";
    //         for(var i=0;  i <ranking_JSON.length; i++){
    //             changehtml+='<a href="#">' + ranking_JSON[i].user_num + "학생" + ranking_JSON[i].point + "개맞춤" + '</a>';
    //             // $('<a href="#">' + ranking_JSON[i].user_num + "학생" + ranking_JSON[i].point + "개맞춤" + '</a>').appendTo('.sidenav');
    //         }
    //         $(".sidenav").html(changehtml);
    //         $("#mid_result").show();
    //         setTimeout(function(){ socket.emit('count','time on');  $("#content").show();  $("#mid_result").hide(); socket.emit('android_nextkey','미정'); }, 3000);
    //     });

    //     socket.on('timer', function (data) {
    //         var counting = data/1000;
    //         document.getElementById('counter').innerText= counting;

    //         document.getElementById("progressBar")
    //             .value = 20 - counting;
    //         if (timeleft == 0)
    //             timeleft = 20;


    //         if(counting == 0 )
    //             socket.emit('count_off','on');
    //     });

    //     //상탄 타임 게이지 바


    //     var x = document.getElementById("mondai");
    //     var A1 = document.getElementById("answer1");
    //     var A2 = document.getElementById("answer2");
    //     var A3 = document.getElementById("answer3");
    //     var A4 = document.getElementById("answer4");


    //     socket.on('answer-sum', function(data){
    //         document.getElementById('answer_c').innerText= data+ "/6명(db) 풀이완료";

    //         if(data == 2)
    //         {

    //             socket.emit('count_off','on');
    //             document.getElementById('answer_c').innerText= "0/6명(db) 풀이완료";

    //         }
    //     });

    //     socket.on('nextok',function(data){

    //         if(quiz_JSON.length == data){
    //             setTimeout(function(){ location.href="/recordbox"; }, 2900);
    //         }
    //         else{
    //             x.innerText  = quiz_JSON[data].name ;
    //             A1.innerText = quiz_JSON[data].answer1;
    //             A2.innerText = quiz_JSON[data].answer2;
    //             A3.innerText = quiz_JSON[data].answer3;
    //             A4.innerText = quiz_JSON[data].answer4;

    //         }
    //     });


    // };

</script>

<div>
    @include('Race.sidebar')
</div>

<div class="main" style="">
    <div id='content'>

        <center>
            <progress style="width:100%;  height:30px;"  value="0" max="20" id="progressBar"></progress>
            <div id="questions" style="height:250px;">

                <div class="inline-class" id="counter"></div>

                <div class="inline-class" id="mondai"><span id="mondai-content"></span></div>

                <div class="inline-class" id="answer_c">Answers</div>

            </div>
        </center>

        <!--문제 번호-->
        <div class="row">
            <div class="column" style="background-color:#1bbc9b; ">
                <p id="answer1">1번</p>
            </div>
            <div class="column" style="background-color:#3598db;">
                <p id="answer2">2번</p>
            </div>
            <div class="column" style="background-color:#f1c40f;">
                <p id="answer3">3번</p>
            </div>
            <div class="column" style="background-color:#e84c3d;">
                <p id="answer4">4번</p>
            </div>
        </div>
    </div>
</div>

<div id='mid_result' style='display:none;' >

    <div id="app">
    </div>
    @include('Race.mid_result')
</div>


</div>

<script src="{{asset('js/app.js')}}"></script>
<script>
    $("#progress").progressTimer({
        timeLimit: 20,
        warningThreshold: 10,
        baseStyle: 'progress-bar-warning',
        warningStyle: 'progress-bar-danger',
        completeStyle: 'progress-bar-info',
        onFinish: function() {
            console.log("I'm done");
        }
    });
</script>
</body>
</html>























