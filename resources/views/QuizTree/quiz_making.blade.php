<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz_making</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="js/bootstrap.min.js" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

    <style type="text/css">

        .contents {
            margin-left: 25%;
        }

        .table tr{
            background-color: white;
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
    @include('QuizTree.quiz_making_sidebar')
</aside>

<script>

    var idNum = 0;

    // 문항 번호(id) 저장용 배열
    var idArray = new Array();

    // 출제 유형 저장용 배열
    var makeTypeRadio = new Array();
    // 문제 유형 저장용 배열
    var quizTypeRadio = new Array();

    $(document).ready(function () {
        $('#listName').change(function () {
            var getListName = $('#listName').val();
            var listNameObj = document.getElementById("listName");
            listNameObj.value = getListName;
        });
    });


    // 메인 -> 문제 테이블 추가 : empty, update, call
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
                    "<td colspan='6'><textarea id='question" + idNum + "' placeholder='여기에 문제를 적어주세요'style='width: 100%; border: 0'>" +
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

        if(addArr.example1 == null) addArr.example1 = "";
        if(addArr.example2 == null) addArr.example2 = "";
        if(addArr.example3 == null) addArr.example3 = "";

        $('#addTr' + idNum).append(
            "<tr>" +
            "<td rowspan='2' style='background-color: #d9edf7'>정답</td>" +
            "<td colspan='3' style='background-color: #EAEAEA'>" +
            "<input id='right" + idNum + "' type='text' placeholder='여기에 정답을 적어주세요' style='width: 100%; background-color: #EAEAEA; border: 0' value='" +
            addArr.right+ "'></td>" +
            "<td colspan='3'>" +
            "<input id='example1" + idNum + "' type='text' placeholder='보기1' style='width: 100%; border: 0' value='" +
            addArr.example1 +"'></td>" +
            "</tr>" +
            "<tr>" +
            "<td colspan='3'>" +
            "<input id='example2" + idNum + "' type='text' placeholder='보기2' style='width: 100%; border: 0' value='" +
            addArr.example2 +"'></td>" +
            "<td colspan='3'>" +
            "<input id='example3" + idNum + "' type='text' placeholder='보기3' style='width: 100%; border: 0' value='" +
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

    // ----->  ★퀴즈 불러오기 파트★

    // 폴더, 퀴즈 리스트 저장용 배열
    var folderData = new Array();
    var quizData = new Array();

    // 미리보기 문제 저장용 배열
    var showListData = new Array();

    // 퀴즈 만들기에 추가될 문제 저장용 배열
    var callQuizData = new Array();

    // AJAX : 폴더 리스트 호출
    $.ajax({
        type: 'POST',
        url: "{{url('quizTreeController/getfolderLists')}}",
        //processData: false,
        //contentType: false,
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //data: {_token: CSRF_TOKEN, 'post':params},
        data: {folderId: '{{$response['folderId']}}'},
        success: function (data) {

            folderData = data;

            for(var i = 0; folderData['folders'].length; i++) {
                $("#folderSelect").append(
                    "<option value='" + folderData['folders'][i]['folderId'] + "'>" + folderData['folders'][i]['folderName'] + "</option>"
                );
            }
        },
        error: function (data) {
            alert("error");
        }
    });

    // 선택된 폴더에 있는 퀴즈리스트 호출
    $(document).ready(function () {
        $("#folderSelect").change(function () {
            var selectedFolder = $("#folderSelect :selected").val();

            $.ajax({
                type: 'POST',
                url: "{{url('quizTreeController/getfolderLists')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: {folderId: selectedFolder},
                success: function (data) {

                    quizData = data;

                    // 퀴즈 선택란 쌓이는 것 방지 : 비워주기
                    $("#quizSelect").empty();
                    $("#quizSelect").append("<option>퀴즈명</option>");

                    for(var i = quizData['lists'].length - 1; i >= 0; i--) {
                        $("#quizSelect").append(
                            "<option value='" + quizData['lists'][i]['listId'] + "'>" + quizData['lists'][i]['listName'] + "</option>"
                        );
                    }
                },
                error: function (data) {
                    alert("error");
                }
            });
        });
    });

    // 선택된 퀴즈 -> 미리보기
    var selectedQuiz;

    $(document).ready(function () {
        $("#quizSelect").change(function () {
            selectedQuiz = $("#quizSelect :selected").val();

            $.ajax({
                type: 'POST',
                url: "{{url('quizTreeController/showList')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: {listId: selectedQuiz},
                success: function (data) {

                    showListData = data;

                    // 쌓이는 문제 데이터 비우기
                    $("#quizShow").empty();
                    $("#quizShow").append("<h4 align='center'>▼미리보기▼</h4>");

                    var str = "";
                    var questionId = 0;

                    for(var i = showListData['quizs'].length-1 ; i >= 0 ; i--) {

                        questionId++;

                        if (showListData['quizs'][i]['hint'] == null) showListData['quizs'][i]['hint'] = "";
                        if (showListData['quizs'][i]['example1'] == null) showListData['quizs'][i]['example1'] = "";
                        if (showListData['quizs'][i]['example2'] == null) showListData['quizs'][i]['example2'] = "";
                        if (showListData['quizs'][i]['example3'] == null) showListData['quizs'][i]['example3'] = "";
                        if (showListData['quizs'][i]['quizType'] == "vocabulary") showListData['quizs'][i]['quizType'] = "어휘";
                        if (showListData['quizs'][i]['quizType'] == "word") showListData['quizs'][i]['quizType'] = "단어";
                        if (showListData['quizs'][i]['quizType'] == "grammar") showListData['quizs'][i]['quizType'] = "문법";

                        if (showListData['quizs'][i]['makeType'] == "obj") {
                            str += "<table class='table table-bordered'>";
                            str += "<tr>";
                            str += "<td style='text-align: center;'>" + questionId + "</td>";
                            str += "<td style='background-color: #d9edf7; width: 22.5%; text-align: center'>출제유형</td>";
                            str += "<td style='width: 22.5%; text-align: center'>객관식</td>";
                            str += "<td style='background-color: #d9edf7; width: 22.5%; text-align: center'>문제유형</td>";
                            str += "<td style='width: 22.5%; text-align: center'>" + showListData['quizs'][i]['quizType'] + "</td>";
                            str += "</tr>";
                            str += "<tr>";
                            str += "<td style='background-color: #d9edf7; text-align: center'>문제</td>";
                            str += "<td colspan='5'>" + showListData['quizs'][i]['question'] + "</td>";
                            str += "</tr>";
                            str += "<tr>";
                            str += "<td style='background-color: #d9edf7; text-align: center'>정답</td>";
                            str += "<td style='background-color: #EAEAEA'>" + showListData['quizs'][i]['right'] + "</td>";
                            str += "<td>" + showListData['quizs'][i]['example1'] + "</td>";
                            str += "<td>" + showListData['quizs'][i]['example2'] + "</td>";
                            str += "<td>" + showListData['quizs'][i]['example3'] + "</td>";
                            str += "</tr>";
                            str += "</table>";
                        }

                        else if (showListData['quizs'][i]['makeType'] == "sub") {
                            str += "<table class='table table-bordered'>";
                            str += "<tr>";
                            str += "<td style='text-align: center;'>" + questionId + "</td>";
                            str += "<td style='background-color: #d9edf7; width: 22.5%; text-align: center'>출제유형</td>";
                            str += "<td style='width: 22.5%; text-align: center'>주관식</td>";
                            str += "<td style='background-color: #d9edf7; width: 22.5%; text-align: center'>문제유형</td>";
                            str += "<td style='width: 22.5%; text-align: center'>" + showListData['quizs'][i]['quizType'] + "</td>";
                            str += "</tr>";
                            str += "<tr>";
                            str += "<td style='background-color: #d9edf7; text-align: center'>문제</td>";
                            str += "<td colspan='5'>" + showListData['quizs'][i]['question'] + "</td>";
                            str += "</tr>";
                            str += "<tr>";
                            str += "<td style='background-color: #d9edf7; text-align: center'>정답</td>";
                            str += "<td colspan='2' style='background-color: #EAEAEA;'>" + showListData['quizs'][i]['right'] + "</td>";
                            str += "<td colspan='2'><힌트> " + showListData['quizs'][i]['hint'] + "</td>";
                            str += "</tr>";
                            str += "</table>";
                        }
                    }

                    $("#quizShow").append(str);

                },
                error: function (data) {
                    alert("error");
                }
            });
        })
    });

    // 모달 : 불러오기 버튼 클릭 시
    function callQuiz() {
        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/showList')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: {listId: selectedQuiz},
            success: function (data) {

                callQuizData = data;

                for(var i = callQuizData['quizs'].length - 1; i >= 0; i--) {

                    var callQuizArray = {
                        question: callQuizData['quizs'][i]['question'],
                        right: callQuizData['quizs'][i]['right'],
                        example1: callQuizData['quizs'][i]['example1'],
                        example2: callQuizData['quizs'][i]['example2'],
                        example3: callQuizData['quizs'][i]['example3'],
                        makeType: callQuizData['quizs'][i]['makeType'],
                        quizType: callQuizData['quizs'][i]['quizType'],
                        hint: callQuizData['quizs'][i]['hint']
                    };

                    quizAdd(callQuizArray);
                }
            },
            error: function (data) {
                alert("error");
            }
        });
    }

    // <----- ★퀴즈 불러오기 파트 끝★

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

        // list 이름
        var listName = $('#listName').val();

        // folder 아이디
        var folderId = "{{$response['folderId']}}";

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
            listName: listName,
            folderId: folderId,
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
                else {
                    alert("빈 항목을 모두 채워주세요");
                    //alert(JSON.stringify(data));
                }
            },
            error: function (data) {
                alert("빈 항목을 모두 채워주세요");
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
        //모달창으로 확인하기
        window.location.href = "{{url('quiz_list')}}";
    }

    // 출력 테스트
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

        <div class="form-inline" style="margin-left: 5%">
            <div style="float: left">
                <!--1. 퀴즈를 새로 생성할 경우-->
                @if(count($response['quizs']) == 0)
                    퀴즈 이름 : <input type="text" id="listName" class="form-control" style="width: 40em" value="">

                <!--2. 퀴즈를 수정할 경우-->
                @elseif(count($response['quizs']) > 0)
                    퀴즈 이름 : <input type="text" id="listName" class="form-control" style="width: 40em" value="{{$response['listName']}}">

                @endif
            </div>
            <div style="text-align: right; margin-right: 5%">
                <button class="btn btn-primary" data-toggle="modal" data-target="#callQuizModal">퀴즈 불러오기</button>
            </div>
        </div>

    <!--문제 박스 : div-->
    <div class="quizBox" style="overflow-y: scroll">

    </div>

    <div class="two_button">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#backToList">종료</button>
        <button type="button" class="btn btn-primary" id="save">저장</button>
        <button type="button" class="btn btn-primary" id="add">추가</button>
    </div>

</div>

<!-- Modal : call Quiz -->
<div class="modal fade" id="callQuizModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">퀴즈 불러오기</h5>
            </div>
            <div class="modal-body">
                {{--Dropdowns--}}
                <div style="text-align: center">
                    <div class="select" style="margin: 0 auto; width: 50%">
                        <select id="folderSelect" class="form-control">
                            <option>폴더명</option>
                            <!-- 폴더 리스트 -->
                        </select>
                    </div>
                    <div class="select" style="margin: 0 auto; margin-top: 1%; width: 50%">
                        <select id="quizSelect" class="form-control">
                            <option>퀴즈명</option>
                            <!-- 퀴즈 리스트 -->
                        </select>
                    </div>
                </div>

                <div id="quizShow" style="margin-top: 2%">
                    <h4 align="center">▼미리보기▼</h4>
                    <!-- 퀴즈 미리보기-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="callQuiz()" data-dismiss="modal">불러오기</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal : back to List -->
<div class="modal fade" id="backToList">
    <div class="modal-dialog">
        <input type="hidden" name="folderName" id="folderName" value="">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body" style="text-align: center">
                퀴즈가 저장되지 않았습니다. 종료하시겠습니까?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="backToList()">종료</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>
