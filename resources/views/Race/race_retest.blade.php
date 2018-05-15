<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

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
</head>
<body>
    <div>@include('Navigation.main_nav')</div>

    <div id="test_content">
        <div class="card" style=" width: 80%; height: 100px; position:relative;">
            <div style="width:40%;" class="test_info">시험제목 </div>
            <div style="width:20%;" class="test_info">1/30 문제 </div>
            <div style="width:10%;" class="test_info"> 재시험 </div>
            <div style="width:10%;" class="test_info"> 김똘d </div>
        </div>

        <br><br>

        <div id="q_table" style="width:80%; height:60%;" class="card">
            <table  style="width:100%;" style="height:100%;">

                <tr>
                    <td colspan="3" style="width:100%; height:400px;" valign="top">
                        <span id="quiz_number">1.</span>
                        <span id="quiz_contents">どうぞ（　　　）お願いいたします。</span><br>
                        <span id="quiz_guide"> 괄호  안에 들어갈 어휘를 선택해주세요</span>

                        <div id="obj" style="display:none;">
                            <br>
                            <label>
                                <input name="answer" type="radio">
                                <span id="answer1" >요로시꾸</span>
                            </label>
                            <br>

                            <label>
                                <input name="answer" type="radio">
                                <span id="answer2">요로시꾸</span>
                            </label>
                            <br>

                            <label>
                                <input name="answer" type="radio">
                                <span id="answer3">요로시d</span>
                            </label>
                            <br>

                            <label>
                                <input name="answer" type="radio">
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
                    <button id="Re-Test"> 다음문제</button>
                    </td> </tr>
            </table>
        </div>
    </div>
</body>
</html>