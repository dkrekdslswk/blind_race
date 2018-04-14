<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Quiz_tree list</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

    <style type="text/css">

        .contents {
            margin-left: 25%;
        }

        .table tr{
            background-color: white;
        }

        td {
            text-align: center;
        }
        
        .two_button {
            margin: 10px 20px 10px 0px;
            text-align: right;
        }

    </style>

</head>
<body onLoad="document.getElementById('add').click();">
<nav>
    @include('Navigation.mainnav')
</nav>

<aside style="display:inline-block; vertical-align:top;">
    @include('Quiz_tree.Quiz_making_side_bar')
</aside>

<script>

    var idNum = 0;
    var idArray = new Array();

    function quizAdd(addArr) {

        // id 값 부여
        idNum++;
        idArray.push(idNum);

        $(".quizBox").append("<div class='quiz' style='margin: 20px'>" +
            "<table class='table table-bordered' id='tableNum"+ idNum +"'>" +
            "<tr>" +
            "<td style='background-color: #d9edf7; width: 10%'>문항</td>" +
            "<td id='quizNum" + idNum +
            "' style='width: 20%'>" + idArray.length +"</td>" +
            "<td style='background-color: #d9edf7; width: 20%;'>문제유형</td>" +
            "<td style='width: 30%'>사지선다</td>" +
            "<td style='width: 10%' id='deleteNum"+ idNum +"'><a href='#'>삭제</a></td>" +
            "</tr>" +
            "<tr>" +
            "<td style='background-color: #d9edf7'>문제</td>" +
            "<td colspan='4'><textarea style='width: 100%; border: 0'>" +
            addArr.question +
            "</textarea></td></tr>" +
            "<tr><td rowspan='2' style='background-color: #d9edf7'>정답</td>" +
            "<td colspan='2' style='background-color: #EAEAEA'>" +
            "<input type='text' style='width: 100%; background-color: #EAEAEA; border: 0' value='" +
            addArr.right+ "'></td>" +
            "<td colspan='2'>" +
            "<input type='text' style='width: 100%; border: 0' value='" +
            addArr.example1 +"'></td></tr>" +
            "<tr><td colspan='2'><input type='text' style='width: 100%; border: 0' value='" +
            addArr.example2 +"'></td>" +
            "<td colspan='2'><input type='text' style='width: 100%; border: 0' value='" +
            addArr.example3 +"'></td></tr></table></div>");


        // 퀴즈 삭제
        $(document).on('click', '#deleteNum'+idNum, function (e) {
            e.preventDefault();

            $('#tableNum'+ this.id.slice(9)).remove();

            var index = idArray.indexOf(Number(this.id.slice(9)));
            idArray.splice(index, 1);

            var count = 0;

            for(var i in idArray) {

                count++;
                var quizId = $('#quizNum'+ idArray[i]);

                quizId.html(count);
            }
        });
    }

    // 문항 추가
    $(document).on('click', '#add', function (e) {
        e.preventDefault();

        var emptyArray = {
            question: "",
            right: "",
            example1: "",
            example2: "",
            example3: ""
        };

        quizAdd(emptyArray);

    });

    // 퀴즈 저장
    $(document).on('click', '#save', function (e) {
        e.preventDefault();

        alert(JSON.stringify(raceData));
    });

</script>

<div class="contents">
    {{--문항 박스 : div--}}
    <div class="quizBox">

    </div>

    <div class="two_button">
        <button type="button" class="btn btn-primary" id="save">저장</button>
        <button type="button" class="btn btn-primary" id="add">추가</button>
    </div>


</div>