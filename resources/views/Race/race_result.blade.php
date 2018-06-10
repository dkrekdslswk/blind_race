<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>레이스 결과 </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script>
        var r_result="";

        window.onload = function() {

            var changehtml ="" ;

            var roomPin = "<?php if(isset($_GET['roomPin'])) echo $_GET['roomPin']; ?>" ;

            var socket = io(':8890');


            socket.emit('join',roomPin);
            socket.emit('race_ending',roomPin);
            $.ajax({
                type: 'POST',
                url: "{{url('/raceController/raceEnd')}}",
                dataType: 'json',
                async:false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },

                success: function (result) {
                    //var r_result = JSON.parse(data);
                    r_result = result['students'];
                    for(var i=0;  i <r_result.length; i++){
                        var append_info ='<tr><td><img src="/img/character/char'+r_result[i].characterId+'.png" width="100px">';
                            append_info +='<a class="user-link title">'+r_result[i].nick+'</a>';
                            append_info +='<span class="user-subhead subtitle">'+r_result[i].rightCount*100+"point"+'</span></td>';


                        if(r_result[i].retestState == false){
                            append_info +='<td><span><img src="/img/race_student/success.png" style="width: 100px"></span></td></tr>';
                            $('#pass_table').append(append_info);
                        }else{
                            append_info +='<td><span><img src="/img/race_student/fail.png" style="width: 100px"></span></td></tr>';
                            $('#fail_table').append(append_info);
                        }


                        // changehtml+='<h3>' + r_result[i].user_num + " 번 학생" + r_result[i].point + "개 맞춤" + '</h3><br>';
                        $('#'+i+'_nick').text(r_result[i].nick);
                        $('#'+i+'_point').text(r_result[i].rightCount*100+"point");
                        $('#'+i+'_character').attr("src", "/img/character/char"+r_result[i].characterId+".png");
                    }
                },
                error: function(request, status, error) {
                    alert("AJAX 에러입니다. ");
                }
            });
            socket.emit('race_result',roomPin ,JSON.stringify(r_result));
        }
    </script>

</head>
<body>

<div> @include('Navigation.main_nav')</div>


<div id="race_result" >
    <input type="hidden" name="_token" value="{{csrf_token()}}">


    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
    <hr>


    <div class="row">
        <div class="col-md-6">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list" id="pass_table">
                            <thead>
                            <tr>
                                <th><span><h2>합격!</h2></span></th>
                                <th><h2>참 잘했어요</h2></th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list" id="fail_table">
                            <thead>
                            <tr>
                                <th><span><h2>불합격!</h2></span></th>
                                <th><h2>노력하세요</h2></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <style>
        body{
            background:#eee;
        }
        .main-box.no-header {
            padding-top: 20px;
        }
        .main-box {
            background: #FFFFFF;
            -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
            box-shadow: 1px 1px 2px 0 #CCCCCC;
            margin-bottom: 16px;
            -webikt-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }
        .table a.table-link.danger {
            color: #e74c3c;
        }
        .label {
            border-radius: 3px;
            font-size: 0.875em;
            font-weight: 600;
        }
        .user-list tbody td .user-subhead {
            font-size: 0.875em;
            font-style: italic;
        }
        .user-list tbody td .user-link {
            display: block;
            font-size: 1.25em;
            padding-top: 3px;
            margin-left: 60px;
        }
        a {
            color: #3498db;
            outline: none!important;
        }
        .user-list tbody td>img {
            position: relative;
            max-width: 50px;
            float: left;
            margin-right: 15px;
        }

        .table thead tr th {
            text-transform: uppercase;
            font-size: 0.875em;
        }
        .table thead tr th {
            border-bottom: 2px solid #e7ebee;
        }
        .table tbody tr td:first-child {
            font-size: 1.125em;
            font-weight: 300;
        }
        .table tbody tr td {
            font-size: 0.875em;
            vertical-align: middle;
            border-top: 1px solid #e7ebee;
            padding: 12px 8px;
        }
    </style>

</div>

<audio autoplay><source src="/bgm/race_result.mp3"></audio>


<a href="/"><button class="btn btn-primary" style="margin-left:50%;">돌아가기</button></a>
</body>
</html>