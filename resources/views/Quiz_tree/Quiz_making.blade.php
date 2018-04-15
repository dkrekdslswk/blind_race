<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Quiz_making</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">

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
                    "<td colspan='4'><textarea id='question" + idNum + "' style='width: 100%; border: 0'>" +
                    addArr.question +
                    "</textarea></td>" +
                "</tr>" +
                "<tr>" +
                    "<td rowspan='2' style='background-color: #d9edf7'>정답</td>" +
                    "<td colspan='2' style='background-color: #EAEAEA'>" +
                    "<input id='right" + idNum + "' type='text' style='width: 100%; background-color: #EAEAEA; border: 0' value='" +
                    addArr.right+ "'></td>" +
                    "<td colspan='2'>" +
                    "<input id='example1" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
                    addArr.example1 +"'></td>" +
                "</tr>" +
                "<tr>" +
                    "<td colspan='2'>" +
                    "<input id='example2" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
                    addArr.example2 +"'></td>" +
                    "<td colspan='2'>" +
                    "<input id='example3" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
                    addArr.example3 +"'></td>" +
                "</tr>" +
            "</table>" +
            "</div>");


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

//      'raceId' => 9,
//            'quizList' => array(
//                [
//                    'question' => '1',
//                    'right' => '1',
//                    'example1' => '2',
//                    'example2' => '3',
//                    'example3' => '4',
//                    'type' => 'o'
//                ],
//                [
//                    'question' => '1',
//                    'right' => '1',
//                    'example1' => '2',
//                    'example2' => '3',
//                    'example3' => '4',
//                    'type' => 'o'
//                ])

    // 퀴즈 저장
    $(document).on('click', '#save', function (e) {
        e.preventDefault();

        // 레이스 아이디
        var raceId = "{{$response['raceId']}}";

        // 문제
        //question + idNum
        //right + idNum
        //example1 + idNum
        //example2 + idNum
        //example3 + idNum
        //type : o

        var quizList = new Array();

        for (var i in idArray) {
            quizList.push({
                question: $('#question' + idArray[i]).val(),
                right: $('#right' + idArray[i]).val(),
                example1: $('#example1' + idArray[i]).val(),
                example2: $('#example2' + idArray[i]).val(),
                example3: $('#example3' + idArray[i]).val(),
                type: 'o'
            });

        }

        var params = {
            raceId: raceId,
            quizList: quizList
        };

        // controller로 data send
        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/insertRace')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {
                if(data.check == true) {
                    alert("저장 완료");
                    window.location.href = "{{url('quizTreeController/folderRaceDataGet/null')}}";
                }
            },
            error: function (data) {
                alert("저장 실패");
            }
        });

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

