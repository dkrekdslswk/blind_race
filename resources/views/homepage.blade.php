<!DOCTYPE html>

<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script
            defer="defer"
            src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"
            integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
            crossorigin="anonymous"></script>
    <title>YourChoice</title>
    <meta charset="utf-8">
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="{{url('css/homemain.css')}}" rel="stylesheet" type="text/css" media="all">

    <script>
        function loginCheck(){
            $.ajax({
                type: 'POST',
                url: "{{url('/userController/loginCheck')}}",
                dataType: 'json',
                async:false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (result) {
                    if(result['check'] == true) {

                        switch(result['classification'])
                        {
                            case 'student' :
                                $('#home_race').attr("href", "/race_student");
                                break;
                            case 'teacher' :
                                $('#home_race').attr("href", "/race_list");
                                break;
                        }

                        $('#login_button').text("Log-Out");
                        $('#login_button').attr("onclick","tryLogout()");
                    }
                    else{
                        $('#home_race').attr("href", "#");
                    }

                },
                error: function(request, status, error) {

                }
            });
            //ajax끝
        }
        function tryLogin(){
            var p_id = $('#web_ID').val();
            var p_pw = $('#web_PW').val();
            $.ajax({
                type: 'POST',
                url: "{{url('/userController/webLogin')}}",
                dataType: 'json',
                async:false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:"p_ID="+p_id+"&p_PW="+p_pw,
                success: function (result) {
                    if(result['check'] == true) {

                        switch(result['classification'])
                        {
                            case 'student' :
                                $('#home_race').attr("href", "/race_student");
                                break;
                            case 'teacher' :
                                $('#home_race').attr("href", "/race_list");
                                break;
                        }

                        document.getElementById('id01').style.display='none';
                        $('#login_button').text("Log-Out");
                        $('#login_button').attr("onclick","tryLogout()");

                    }
                    else{
                        alert("로그인실패");
                    }

                },
                error: function(request, status, error) {

                }
            });
            //ajax끝
        }

        function tryLogout(){
            $.ajax({
                type: 'POST',
                url: "{{url('/userController/webLogout')}}",
                dataType: 'json',
                async:false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (result) {
                    $('#login_button').text("Log-in");
                    $('#login_button').attr("onclick","tryLogin()");
                    alert("로그아웃되었습니다.");
                    window.location.reload();
                },
                error: function(request, status, error) {
                    alert("로그아웃 실패 ");
                }
            });
        }
    </script>

</head>
<body
        id="top"
        onload="loginCheck()";
        class="bgded fixed"
        style="background-image:url('https://i.imgur.com/BMhEarm.jpg');">



<div class="wrapper row1">
    <header id="header" class="clear">

        <div id="logo" class="fl_left">
            <h1>
                <a href="#">
                    <em>十</em>分<em>十</em>分</a>
            </h1>
        </div>
        <nav id="mainav" class="fl_right">
            <ul class="clear">
                <li class="active">
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="{{ url('mygroup') }}">나의 그룹</a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('race_list') }}">레이스

                </li>


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('recordbox') }}">레코드박스
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('recordbox') }}">레코드 박스</a>
                        </li>
                        <li>
                            <a href="#">오답노트</a>
                        </li>
                        <li>
                            <a href="/Feedback">피드백</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('quiz_list') }}">문제 나무</a>
                </li>
                <li>

                    <button id="login_button"  onclick="document.getElementById('id01').style.display='block'" class="mainbtn">Log-in</button>
                </li>
                <li>

                    <button onclick="document.getElementById('id02').style.display='block'" class="mainbtn">Sign up</button>
                </li>
                <ul></ul>
        </nav>

    </header>
</div>

<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<script type="text/javascript" charset="utf-8">
    var $ = jQuery.noConflict();
    $(window).load(function() {
        $('.flexslider').flexslider({
            animation: "fade"
        });

        $(function() {
            $('.show_menu').click(function(){
                $('.menu').fadeIn();
                $('.show_menu').fadeOut();
                $('.hide_menu').fadeIn();
            });
            $('.hide_menu').click(function(){
                $('.menu').fadeOut();
                $('.show_menu').fadeIn();
                $('.hide_menu').fadeOut();
            });
        });
    });
</script>
</head>
<body>

<div class="flexslider">

            <a href="http://www.naver.com"><img src="https://i.imgur.com/selEFaM.png" alt="" title=""/></a>
            <div class="flex-caption">

            </div>
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="http://www.freshdesignweb.com"><img src="https://i.imgur.com/selEFaM.png" alt="" title=""/></a>--}}
            {{--<div class="flex-caption">--}}
            {{--</div>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="http://www.freshdesignweb.com"><img src="https://i.imgur.com/selEFaM.png" alt="" title=""/></a>--}}
            {{--<div class="flex-caption">--}}
            {{--</div>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="http://www.freshdesignweb.com"><img src="https://i.imgur.com/selEFaM.png" alt="" title=""/></a>--}}
            {{--<div class="flex-caption">--}}
            {{--</div>--}}
        {{--</li>--}}
    </ul>
</div>
</div>
</div>
</div>


<div id="pageintro" >


    <ul class="nospace group">

        <li>
            <i>MY Class</i>
            <a class="mt-purple" href="/mygroup">
                <i class="fa fa-5x fa-child"></i>

            </a>
        </li>

        <li>
            {{--<a class="mt-green" href="{{ url('race_list') }}">--}}
            <i >Race</i>
            <a class='mt-green' id="home_race">
                <i class="fa fa-5x fa-gamepad"></i>

            </a>
        </li>
        <li>
            <i>Record Box</i>
            <a class="mt-red" href="/recordbox">
                <i class="fa fa-5x fa-box-open"></i>

            </a>
        </li>
        <li>
            <i>Quiz Tree</i>
            <a class="mt-yellow" href="{{ url('quiz_list') }}">
                <i class="fa fa-5x fa-tree"></i>

            </a>
        </li>


        <li>
            <i>Feedback</i>
            <a class="mt-orange" href="/raid">
                <i class="fa fa-5x fa-comments"></i>

            </a>
        </li>



    </ul>


    </ul>

</div>






</div>
</div>
</div>



<div class="row5">
    <div class="lrspace">
        <div id="copyright" class="clear">

            <p class="fl_left">Copyright &copy; 2018 - WDJ 17조 -
                <a href="#">캡스톤 디자인</a>
            </p>
            <p class="fl_right">Template By
                <a
                        target="_blank"
                        href="http://www.os-templates.com/"
                        title="Free Website Templates">WDJ7조</a>
            </p>

        </div>
    </div>
</div>

<a id="backtotop" href="#top">
    <i class="fa fa-chevron-up"></i>
</a>



<div id="id01" class="modal">
    <div class="modal-content">
        <div class="imgcontainer">

            <span
                    onclick="document.getElementById('id01').style.display='none'"
                    class="close"
                    title="Close Modal">&times;</span>
            <!-- <img src="https://i.imgur.com/pDvUuvf.png" alt="Avatar2" class="avatar" width ="200px"> -->
        </div>

        <div class="container">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <label for="p_ID">
                <b>학 번</b>
            </label>
            <input
                    id="web_ID"
                    type="text"
                    placeholder="학번을  입력"
                    name="p_ID"
                    required="required"
                    value="123456789">

            <label for="p_PW">
                <b>Password</b>
            </label>
            <input
                    id="web_PW"
                    type="password"
                    placeholder="Enter Password"
                    name="p_PW"
                    required="required"
                    value="sub"
            >

            <button type="button" style ="color : black" onclick="tryLogin()">Login</button>



        </div>

    </div>
</div>

<div id="id02" class="modal">
    <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>



    <form class="modal-content" action="{{url('userController/webLogin')}}"  method="Post" enctype="multipart/form-data">
        <div class="container">
            <h1>Sign Up</h1>

            <hr>
            <label for="text"><b>Student ID</b></label>
            <input type="text" placeholder="Student ID" name="ID" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" required>





            <div class="clearfix">
                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Sign Up</button>
            </div>
        </div>
    </form>
</div>


<!-- JAVASCRIPTS -->

<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/mi.js')}}"></script>
<script src="{{url('js/jquery.backtotop.js')}}"></script>
<script src="{{url('js/jquery.mobilemenu.js')}}"></script>


<script>

    //    alert(JSON.stringify( $returnvalue));
    // alert('<?php //echo $returnvalue; ?>');
    var modal = document.getElementById('id01');


    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var modal = document.getElementById('id02');


    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>
<style>
    img {
        width: 1700px; !important;
        height: auto;
        margin: 0;
        padding: 0;
        border: none;
        line-height: normal;
        vertical-align: middle;
    }

    #pageintro ul {
    }
</style>

</body>

</html>