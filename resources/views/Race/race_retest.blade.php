<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <link href="js/bootstrap.min.js" rel="stylesheet">


    <style>

        .test_info{
            display:inline-block;
            float:left;
            font-size:20px;
            vertical-align: bottom;
        }
        body{
            background: #00BCD4 !important;
        }
        #q_table{
            background-color:white;
        }
        .card{
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            background-color:white;
        }
        #test_content{
            margin-top:10%;
            margin-left:10%;
        }
        * { box-sizing:border-box; }

        /* basic stylings ------------------------------------------ */
        body 				 { background:url(https://scotch.io/wp-content/uploads/2014/07/61.jpg); }
        .container 		{
            font-family:'Roboto';
            width:600px;
            margin:30px auto 0;
            display:block;
            background:#FFF;
            padding:10px 50px 50px;
        }
        h2 		 {
            text-align:center;
            margin-bottom:50px;
        }
        h2 small {
            font-weight:normal;
            color:#888;
            display:block;
        }
        .footer 	{ text-align:center; }
        .footer a  { color:#53B2C8; }

        /* form starting stylings ------------------------------- */
        .group 			  {
            position:relative;
            margin-bottom:45px;
        }
        #sub_content 				{
            font-size:18px;
            padding:10px 10px 10px 5px;
            display:block;
            width:300px;
            border:none;
            border-bottom:1px solid #757575;
        }
        input:focus 		{ outline:none; }

        /* LABEL ======================================= */
        #sub_guide {
            color:#999;
            font-size:18px;
            font-weight:normal;
            position:absolute;
            pointer-events:none;
            left:5px;
            top:10px;
            transition:0.2s ease all;
            -moz-transition:0.2s ease all;
            -webkit-transition:0.2s ease all;
        }

        /* active state */
        input:focus ~ label, input:valid ~ label 		{
            top:-20px;
            font-size:14px;
            color:#5264AE;
        }

        /* BOTTOM BARS ================================= */
        .bar 	{ position:relative; display:block; width:300px; }
        .bar:before, .bar:after 	{
            content:'';
            height:2px;
            width:0;
            bottom:1px;
            position:absolute;
            background:#5264AE;
            transition:0.2s ease all;
            -moz-transition:0.2s ease all;
            -webkit-transition:0.2s ease all;
        }
        .bar:before {
            left:50%;
        }
        .bar:after {
            right:50%;
        }

        /* active state */
        input:focus ~ .bar:before, input:focus ~ .bar:after {
            width:50%;
        }

        /* HIGHLIGHTER ================================== */
        .highlight {
            position:absolute;
            height:60%;
            width:100px;
            top:25%;
            left:0;
            pointer-events:none;
            opacity:0.5;
        }

        /* active state */
        input:focus ~ .highlight {
            -webkit-animation:inputHighlighter 0.3s ease;
            -moz-animation:inputHighlighter 0.3s ease;
            animation:inputHighlighter 0.3s ease;
        }

        /* ANIMATIONS ================ */
        @-webkit-keyframes inputHighlighter {
            from { background:#5264AE; }
            to 	{ width:0; background:transparent; }
        }
        @-moz-keyframes inputHighlighter {
            from { background:#5264AE; }
            to 	{ width:0; background:transparent; }
        }
        @keyframes inputHighlighter {
            from { background:#5264AE; }
            to 	{ width:0; background:transparent; }
        }

        .retest_footer{
            background-color:rgba(25,25,112,0.3);
            width:50%;
            height:80px;
        }
        #Re-Test{
            width:300px;
            height:90%;
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
        #Re-Test:hover , #Re-Test:active ,#Re-Test:active:focus{
            background:green;
        }
    </style>

    <script>
        var sessionId = '<?php echo $response['sessionId']; ?>';
        var raceId = '<?php echo $response['raceId']; ?>';

        var quizId;
        var quizCount;
        var quiz_JSON;
        var retest_quiz_num =0;

        var quiz_answer_list = [1,2,3,4];
        var rightAnswer;
        var real_A;

        var selected_answer;

        //quizId , sessionId , answer

        window.onload = function(){
            function shuffle(a) {

                var j, x, i;
                for (i = a.length; i; i -= 1) {
                    j = Math.floor(Math.random() * i);
                    x = a[i - 1];
                    a[i - 1] = a[j];
                    a[j] = x;
                }
            }
            function Create2DArray(rows) {
                var arr = [];

                for (var i=0;i<rows;i++) {
                    arr[i] = [];
                }

                return arr;
            }

            function shuffle_quiz(){

                real_A = Create2DArray(quiz_JSON.length);

                for(var i = 0; i <quiz_JSON.length; i++){

                    if( quiz_JSON[i].makeType == "obj"){

                        shuffle(quiz_answer_list);

                        real_A[i][quiz_answer_list[0]] = quiz_JSON[i].right;
                        real_A[i][quiz_answer_list[1]] = quiz_JSON[i].example1;
                        real_A[i][quiz_answer_list[2]] = quiz_JSON[i].example2;
                        real_A[i][quiz_answer_list[3]] = quiz_JSON[i].example3;

                        for(var j = 0; j<=3; j++){
                            switch(quiz_answer_list[j]){
                                case 1: quiz_JSON[i].right = real_A[i][quiz_answer_list[j]];
                                    break;
                                case 2: quiz_JSON[i].example1 = real_A[i][quiz_answer_list[j]];
                                    break;
                                case 3: quiz_JSON[i].example2 = real_A[i][quiz_answer_list[j]];
                                    break;
                                case 4: quiz_JSON[i].example3 = real_A[i][quiz_answer_list[j]];
                                    break;
                            }
                        }
                    }
                }
            }

            $.ajax({
                type: 'POST',
                url: "{{url('raceController/retestStart')}}",
                dataType: 'json',
                async:false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:"raceId="+raceId+"&sessionId="+sessionId,
                
                success: function (result) {
                    $('#raceName').text(result['listName']);
                    $('#quizCount').text(result['quizCount']+"문제");
                    $('#passingMark').text("합격점:"+result['passingMark']);
                    $('#groupName').text(result['groupName']);
                    $('#userName').text(result['userName']);

                    quizCount = result['quizCount'];
                    quiz_JSON = result['quizs']['quiz'];
                    shuffle_quiz();

                    quizGet();

                },
                error: function (data) {
                    alert("error");
                }
            });
        };
        function nextQuiz(){

            quizId = quiz_JSON[retest_quiz_num-1].quizId;

            if(quiz_JSON[retest_quiz_num-1].makeType == "sub")
                selected_answer = document.getElementById('sub_content').value;

            $.ajax({
                type: 'POST',
                url: "{{url('raceController/retestAnswerIn')}}",
                dataType: 'json',
                data:"quizId="+quizId+"&sessionId="+sessionId+"&answer="+selected_answer,
                success: function (result) {
                    
                },
                error: function (data) {
                    alert("학생 재시험정답입력 error");
                }
            });

            quizGet();
        }

        function quizGet(){
            $('#quiz_number').text(retest_quiz_num+1);
            $('#quiz_contents').text(quiz_JSON[retest_quiz_num].question);

            switch(quiz_JSON[retest_quiz_num].makeType){
                
                case "obj":
                    selected_answer = quiz_JSON[retest_quiz_num].right;
                    $('#quiz_guide').text('괄호  안에 들어갈 답을 선택해주세요');
                    $('#answer1').text(quiz_JSON[retest_quiz_num].right);
                    $('#answer1_radio').val(quiz_JSON[retest_quiz_num].right);

                    $('#answer2').text(quiz_JSON[retest_quiz_num].example1);
                    $('#answer2_radio').val(quiz_JSON[retest_quiz_num].example1);

                    $('#answer3').text(quiz_JSON[retest_quiz_num].example2);
                    $('#answer3_radio').val(quiz_JSON[retest_quiz_num].example2);

                    $('#answer4').text(quiz_JSON[retest_quiz_num].example3);
                    $('#answer4_radio').val(quiz_JSON[retest_quiz_num].example3);

                    $('#obj').show();
                    $('#sub').hide();
                    break;
                    
                case "sub":
                    $('#quiz_guide').text('괄호  안에 들어갈 답을 입력 해 주세요');
                    $('#sub').show();
                    $('#obj').hide();
                    break;
            }
            retest_quiz_num++;
        }

    </script>

    <script>

        $(document).on("change","input[type=radio][name=answer]",function(event){
            selected_answer = this.value;
        });

    </script>

</head>
<body>
<div>@include('Navigation.main_nav')</div>

<div id="test_content">
    <div class="card"         style=" width: 80%; height: 100px; position:relative;">
        <div id="raceName"    style="width:40%;" class="test_info">문제제목</div>
        <div id="quizCount"   style="width:20%;" class="test_info">1/30 문제 </div>
        <div id="passingMark" style="width:10%;" class="test_info"> 합격점 </div>
        <div id="groupName"   style="width:10%; margin-left:5%;" class="test_info"> 그룹아이디 </div>
        <div id="userName"    style="width:15%;" class="test_info"> 김똘d </div>
    </div>

    <br><br>

    <div id="q_table" style="width:80%; height:60%;" class="card">
        <table  style="width:100%;" style="height:100%;">

            <tr>
                <td colspan="3" style="width:100%; height:400px;" valign="top">
                    <span id="quiz_number">1.</span>
                    <span id="quiz_contents">どうぞ（　　　）お願いいたします。</span><br>
                    <span id="quiz_guide"> 괄호  안에 들어갈 답을 선택해주세요</span>

                    <div id="obj" style="display:none;">
                        <br>
                        <label>
                            <input id="answer1_radio" name="answer" type="radio" checked="checked">
                            <span id="answer1" >요로시꾸</span>
                        </label>
                        <br>

                        <label>
                            <input id="answer2_radio"  name="answer" type="radio">
                            <span id="answer2">요로시꾸</span>
                        </label>
                        <br>

                        <label>
                            <input id="answer3_radio"  name="answer" type="radio">
                            <span id="answer3">요로시d</span>
                        </label>
                        <br>

                        <label>
                            <input id="answer4_radio"  name="answer" type="radio">
                            <span id="answer4">요로시꾸</span>
                        </label>
                        <br>
                    </div>

                    <div id="sub" style="display:none;">
                        <div class="group">
                            <input id="sub_content" type="text" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label id="sub_guide">주관식답안</label>
                        </div>
                    </div>

                </td>
            </tr>

            <tr> <td class="retest_footer" style=" text-align: right; color:white; font-size:20px; border-top:1px solid black;">1/30</td>
                <td class="retest_footer"  style=" text-align: right;">
                    <button id="Re-Test" onclick="nextQuiz();"> 다음문제</button>
                </td> </tr>
        </table>
    </div>
</div>
</body>
</html>