<?php
/**
 * Created by PhpStorm.
 * User: kimseungmok
 * Date: 2018-03-28
 * Time: 오후 7:57
 *
 * 레이스 기본 네비게이션
 */
?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Waiting Room Navigator</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript">

        // Array ( [race] => Array ( [raceName] => 테스트용 레이스1 [examCount] => 30 ) [group] =>
        // Array ( [groupName] => group1 [groupStudentCount] => 5 ) [sessionId] => 1 [check] => 1 )

        function nav_load(){
            $('#race_name').html('<?php echo $json['race']['raceName']; ?>');
            $('#race_count').html('<?php echo $json['race']['examCount']; ?>');
            $('#group_name').html('<?php echo $json['group']['groupName']; ?>');
            $('#group_student_count').html('<?php echo $json['group']['groupStudentCount']; ?>' + "명");
        }


    </script>


    <style>
        .race_container {
            background-color : #212529;
            margin : 0px;
            width : 100%;
            height: 100px;
        }

        .navbar-brand {
            border: 1px solid white;
            color: white;
            font-family: 'a옛날사진관3';
            font-size: 30px;
            text-align: left;
        }

        .race_container ul li {
            background-color: white;
            color: black;
            font-family: 'a옛날사진관3';
            font-size: 30px;
            margin-right: 15px;
        }

        .group ul {
            position: absolute;
            right: 20px;"
        }

        .group ul li {
            background-color: #212529;
            color: white;
            font-family: 'a옛날사진관3';
            font-size: 30px;
            margin-right: 15px;
        }
        .nav-color{
            background-color:#2e353d;
        }
    </style>

</head>
<body onload="nav_load();">

<div class="race_container">
    <nav class="navbar navbar-expand-lg nav-color" style="height: 100%;">
        <div class="navbar-brand">
            블라인드 레이스
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav navbar-sidenav">
                <li class="nav-item">
                    <div class="nav-link" style="height: 100%;" id="race_name">레이스 이름
                    </div>
                </li>
                <li class="nav-item">
                    <span class="nav-link" style="height: 100%;" id="race_count">레이스 문항 수
                    </span>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item blank">

                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse group">
            <ul class="navbar-nav sidenav-toggler group">
                <li class="nav-item">
                    <span class="nav-link" style="height: 100%;" id="group_name">그룹 이름
                    </span>
                </li>
                <li class="nav-item" >
                    <span class="nav-link" style="height: 100%; display: inline-block;" id="group_student_count">학생 총 수
                    </span>
                </li>
            </ul>
        </div>
    </nav>
</div>
</body>
</html>