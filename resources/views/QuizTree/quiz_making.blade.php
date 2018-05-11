<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Quiz_making</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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

        .btn-lg {
            font-size: 18px;
            line-height: 1.33;
            border-radius: 6px;
        }

        .btn.outline {
            background: none;
            padding: 12px 22px;
        }
        .btn-primary.outline {
            border: 2px solid #0099cc;
            color: #0099cc;
        }



    </style>
</head>

<!--1. 퀴즈를 새로 생성할 경우-->
@if(count($response['quizs']) == 0)
    <body onload="document.getElementById('add').click();">

<!--2. 퀴즈를 수정할 경우-->
@elseif(count($response['quizs']) > 0)
    <body onload="updateQuiz()">

    @endif

<nav>
    @include('Navigation.main_nav')
</nav>

<aside style="display:inline-block; vertical-align:top;">
    @include('QuizTree.quiz_making_side_bar')
</aside>

<script>

    var idNum = 0;

    // 문항 번호(id) 저장용 배열
    var idArray = new Array();

    // 출제 유형 저장용 배열
    var makeTypeRadio = new Array();
    // 문제 유형 저장용 배열
    var quizTypeRadio = new Array();

    // 메인 -> 문제 테이블 추가 : empty, update
    function quizAdd(addArr) {

        // id 값 부여 + 배열에 저장
        idNum++;
        idArray.push(idNum);

        // quizBox Div에 table 추가
        $(".quizBox").append(
            "<div class='quiz' style='margin: 20px'>" +
            "<table class='table table-bordered' id='tableNum"+ idNum +"'>" +
                "<thead>" +
                    "<td style='background-color: #d9edf7; width: 10%'>문항</td>" +
                    "<td id='quizNum" + idNum + "' style='width: 10%'>" + idArray.length +"</td>" +
                    "<td style='background-color: #d9edf7; width: 10%;'>출제유형</td>" +
                    "<td style='width: 25%'>" +
                        "<form>" +
                        "<label class='radio-inline'><input type='radio' id='obj" + idNum + "' name='makeType" + idNum + "' value='obj'>객관식</label>" +
                        "<label class='radio-inline'><input type='radio' id='sub" + idNum + "' name='makeType" + idNum + "' value='sub'>주관식</label>" +
                        "</form>" +
                    "</td>" +
                    "<td style='background-color: #d9edf7; width: 10%;'>문제유형</td>" +
                    "<td style='width: 25%'>" +
                        "<form>" +
                        "<label class='radio-inline'><input type='radio' id='voc" + idNum + "' name='quizType" + idNum + "' value='vocabulary'>어휘</label>" +
                        "<label class='radio-inline'><input type='radio' id='wor" + idNum + "' name='quizType" + idNum + "' value='word'>단어</label>" +
                        "<label class='radio-inline'><input type='radio' id='gra" + idNum + "' name='quizType" + idNum + "' value='grammar'>문법</label>" +
                        "</form>" +
                    "</td>" +
                    "<td style='width: 10%' id='deleteNum"+ idNum +"'><a href='#'>삭제</a></td>" +
                "</thead>" +
                "<tbody>" +
                "<tr>" +
                    "<td style='background-color: #d9edf7'>문제</td>" +
                    "<td colspan='6'><textarea id='question" + idNum + "' style='width: 100%; border: 0'>" +
                    addArr.question +
                    "</textarea></td>" +
                "</tr>" +
                "</tbody>" +
                "<tfoot id='addTr" + idNum + "'>" +
                /*"<tr>" +
                    "<td rowspan='2' style='background-color: #d9edf7'>정답</td>" +
                    "<td colspan='3' style='background-color: #EAEAEA'>" +
                    "<input id='right" + idNum + "' type='text' style='width: 100%; background-color: #EAEAEA; border: 0' value='" +
                    addArr.right+ "'></td>" +
                    "<td colspan='3'>" +
                    "<input id='example1" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
                    addArr.example1 +"'></td>" +
                "</tr>" +
                "<tr>" +
                    "<td colspan='3'>" +
                    "<input id='example2" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
                    addArr.example2 +"'></td>" +
                    "<td colspan='3'>" +
                    "<input id='example3" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
                    addArr.example3 +"'></td>" +
                "</tr>" +*/
                "</tfoot>" +
            "</table>" +
            "</div>");


        // 받아온 값(교재 정보 or 수정 문제)으로 라디오버튼 표시
        if(addArr.makeType == "obj") {
            $("#obj" + idNum).attr("checked", true);
            makeTypeRadio[idNum] = addArr.makeType;
            addObj(idNum, addArr);
        }

        else if(addArr.makeType == "sub") {
            $("#sub" + idNum).attr("checked", true);
            makeTypeRadio[idNum] = addArr.makeType;
            addSub(idNum, addArr);
        }

        if(addArr.quizType == "vocabulary") {
            $("#voc" + idNum).attr("checked", true);
            quizTypeRadio[idNum] = addArr.quizType;
        }

        else if(addArr.quizType == "word") {
            $("#wor" + idNum).attr("checked", true);
            quizTypeRadio[idNum] = addArr.quizType;
        }

        else if(addArr.quizType == "grammar") {
            $("#gra" + idNum).attr("checked", true);
            quizTypeRadio[idNum] = addArr.quizType;
        }


        // 라디오버튼 선택 확인 (출제유형)
        $("input[name='makeType" + idNum + "']:radio").change(function () {

            // 테이블 변형 : 주관식일 경우 addSub() 메서드 호출
            if(this.id.slice(0,3) == "sub") {
                makeTypeRadio[this.id.slice(3)] = "sub";
                addSub(this.id.slice(3), addArr);
            }

            // 테이블 변형 : 객관식일 경우 addObj() 메서드 호출
            else if (this.id.slice(0,3) == "obj") {
                makeTypeRadio[this.id.slice(3)] = "obj";
                addObj(this.id.slice(3), addArr);
            }

        });

        // 라디오버튼 선택 확인 (문제유형)
        $("input[name='quizType" + idNum + "']:radio").change(function () {

            if(this.id.slice(0,3) == "voc")
                quizTypeRadio[this.id.slice(3)] = "vocabulary";

            else if(this.id.slice(0,3) == "wor")
                quizTypeRadio[this.id.slice(3)] = "word";

            else if(this.id.slice(0,3) == "gra")
                quizTypeRadio[this.id.slice(3)] = "grammar";
        });


        // 문항 삭제 버튼 클릭 시
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

    // 테이블 : 객관식 용 (칸 4개)
    function addObj(idNum, addArr) {
        $('#addTr' + idNum).empty();

        $('#addTr' + idNum).append(
            "<tr>" +
            "<td rowspan='2' style='background-color: #d9edf7'>정답</td>" +
            "<td colspan='3' style='background-color: #EAEAEA'>" +
            "<input id='right" + idNum + "' type='text' placeholder='정답을 적어주세요' style='width: 100%; background-color: #EAEAEA; border: 0' value='" +
            addArr.right+ "'></td>" +
            "<td colspan='3'>" +
            "<input id='example1" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
            addArr.example1 +"'></td>" +
            "</tr>" +
            "<tr>" +
            "<td colspan='3'>" +
            "<input id='example2" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
            addArr.example2 +"'></td>" +
            "<td colspan='3'>" +
            "<input id='example3" + idNum + "' type='text' style='width: 100%; border: 0' value='" +
            addArr.example3 +"'></td>" +
            "</tr>"
        );
    }

    // 테이블 : 주관식 용 (칸 2개)
    function addSub(idNum, addArr) {
        $('#addTr' + idNum).empty();

        if(addArr.hint == null) addArr.hint = "";

        $('#addTr' + idNum).append(
            "<tr>" +
            "<td rowspan='2' style='background-color: #d9edf7'>정답</td>" +
            "<td colspan='3' style='background-color: #EAEAEA'>" +
            "<input id='right" + idNum + "' type='text' placeholder='복수 정답일 경우 ,(콤마)로 표시해주세요' style='width: 100%; background-color: #EAEAEA; border: 0' value='" +
            addArr.right+ "'></td>" +
            "<td colspan='3'>" +
            "<input id='hint" + idNum + "' type='text' placeholder='여기에 힌트를 적어주세요' style='width: 100%; border: 0' value='" +
            addArr.hint +"'></td>" +
            "</tr>"
        );
    }

    // 문항 추가 버튼 클릭 시 + 퀴즈 생성(BODY ONLOAD)
    $(document).on('click', '#add', function (e) {
        e.preventDefault();

        // 새로운 퀴즈
        var emptyArray = {
            question: "",
            right: "",
            example1: "",
            example2: "",
            example3: "",
            makeType: "obj",
            quizType: "",
            hint: ""
        };

        quizAdd(emptyArray);

    });

    // 퀴즈 저장 버튼 클릭 시
    $(document).on('click', '#save', function (e) {
        e.preventDefault();

        // list 아이디
        var listId = "{{$response['listId']}}";

        // 문제
        //question + idNum
        //right + idNum
        //example1 + idNum
        //example2 + idNum
        //example3 + idNum
        //type : o

        var quizs = new Array();

        for (var i in idArray) {
            quizs.push({
                question: $('#question' + idArray[i]).val(),
                right: $('#right' + idArray[i]).val(),
                example1: $('#example1' + idArray[i]).val(),
                example2: $('#example2' + idArray[i]).val(),
                example3: $('#example3' + idArray[i]).val(),
                makeType: makeTypeRadio[idArray[i]],
                quizType: quizTypeRadio[idArray[i]],
                hint: $('#hint' + idArray[i]).val()
            });
        }

        var params = {
            listId: listId,
            quizs: quizs
        };

        // controller로 data send
        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/insertList')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {
                if(data.check == true) {
                    alert("저장 완료");
                    window.location.href = "{{url('quiz_list')}}";
                }
            },
            error: function (data) {
                alert("error");
            }
        });

    });

    // 수정 퀴즈(BODY ONLOAD) : 기존에 저장된 문제 목록 불러오기
    function updateQuiz() {

        @for($i = count($response['quizs']) - 1; $i >= 0; $i--)

        var updateArray = {
            question: "{{$response['quizs'][$i]['question']}}",
            right: "{{$response['quizs'][$i]['right']}}",
            example1: "{{$response['quizs'][$i]['example1']}}",
            example2: "{{$response['quizs'][$i]['example2']}}",
            example3: "{{$response['quizs'][$i]['example3']}}",
            makeType: "{{$response['quizs'][$i]['makeType']}}",
            quizType: "{{$response['quizs'][$i]['quizType']}}",
            hint: "{{$response['quizs'][$i]['hint']}}"
        };

        quizAdd(updateArray);

        @endfor
    };

    // 목록으로 버튼 클릭 시 : quiz_list로 돌아가기
    function backToList() {
        window.location.href = "{{url('quiz_list')}}";
    }

    // 테스트
    $(document).on('click', '#test', function (e) {
        e.preventDefault();

        var listId = "{{$response['listId']}}";

        var quizs = new Array();

        for (var i in idArray) {
            quizs.push({
                question: $('#question' + idArray[i]).val(),
                right: $('#right' + idArray[i]).val(),
                example1: $('#example1' + idArray[i]).val(),
                example2: $('#example2' + idArray[i]).val(),
                example3: $('#example3' + idArray[i]).val(),
                makeType: makeTypeRadio[idArray[i]],
                quizType: quizTypeRadio[idArray[i]],
                hint: $('#hint' + idArray[i]).val()
            });
        }

        alert(listId);
        alert(JSON.stringify(quizs));
    });

</script>


<div class="contents">

    <div id="quizTitle" style="margin-left: 5%" class="form-inline">
        <button type="button" class="btn btn-primary btn-lg outline">퀴즈명 : {{$response['listName']}}</button>
    </div>

    <!--문제 박스 : div-->
    <div class="quizBox">

    </div>

    <div class="two_button">
        <button type="button" class="btn btn-primary" onclick="backToList()">목록으로</button>
        <button type="button" class="btn btn-primary" id="save">저장</button>
        <button type="button" class="btn btn-primary" id="add">추가</button>
    </div>

</div>

