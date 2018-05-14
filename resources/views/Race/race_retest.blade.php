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
            font-size:30px;
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
    </style>
</head>
<body>
    <div>@include('Navigation.main_nav')</div>

    <div id="test_content">
        <div class="card" style=" width: 80%; height: 100px; position:relative;">
            <div style="width:40%;" class="test_info">시험제목 </div>
            <div style="width:20%;" class="test_info">1/30 문제 </div>
            <div style="width:10%;" class="test_info"> 재시험 </div>
            <div style="width:5%;" class="test_info"> 김똘똘 </div>
        </div>

        <br><br>

        <div id="q_table" style="width:80%; height:60%;" class="card">
            <table  style="width:100%;" style="height:100%;">

                <tr>
                    <td colspan="3" style="width:100%; height:500px;">
                      <span id="quiz_number">1.</span>
                      <span id="quiz_contents">どうぞ（　　　）お願いいたします。</span>
                      <span id="quiz_guide"> 괄호  안에 들어갈 어휘를 선택해주세요</span>

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
                    </td>
                </tr>

                <tr> <td style=" text-align: right; border-top:1px solid black;">1/30</td><td style=" text-align: right;">다음</td> </tr>
            </table>
        </div>
    </div>
</body>
</html>