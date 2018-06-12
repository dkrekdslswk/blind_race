<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<body onload="loginCheck()";>
<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a  href="#"><img src="{{ asset('https://i.imgur.com/dmXfbDm.png') }}" style="width:125px; height:50px; "/></a>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="{{ url('mygroup') }}">My Class</a>
                </li>
                <li>
                    <a href="{{ url('race_list') }}">Race</a>
                </li>
                <li>
                    <a href="{{ url('recordbox') }}">RecordBox</a>
                </li>
                <li>
                    <a href="{{ url('quiz_list') }}">QuizTree</a>
                </li>
            </ul>
            <form id="signin" class="navbar-form navbar-right" role="form">
                <div class="input-group">
                    <span ></span>
                    <input id="web_ID"   name="p_ID" value="" placeholder="ID" class="invi">
                </div>

                <div class="input-group">
                    <span ></span>
                    <input  id="web_PW" name="p_PW" value="" placeholder="PASSWORD" class="invi">
                </div>
                <button type="button" class="btn-primary-outline btn-round-lg" style ="color : black" onclick="tryLogin()">Login</button>

            </form>

        </div>
    </div>
</nav>
<style>
    .invi {
        background-color: transparent !important;
        border: 0px;
    }
    .btn-primary-outline {
        background-color: transparent;
        border-color: #ccc;
    }
    .btn-round-lg {
        border-radius: 20.5px;
    }
</style>
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

//                    document.getElementById('id01').style.display='none';
//                    준휘야 여기 머들어가야 되노 ?
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