<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz list</title>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <style type="text/css">

        .panel-table .panel-body{
            padding:0;
        }

        .panel-table .panel-body .table-bordered{
            border-style: none;
            margin:0;
        }

        .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
            text-align:center;
            width: 150px;
        }

        .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
        .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
            border-right: 0px;
        }

        .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
        .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
            border-left: 0px;
        }

        .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
            border-bottom: 0px;
        }

        .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
            border-top: 0px;
        }

        .panel-table .panel-footer .pagination{
            margin:0;
        }

        .panel-table .panel-footer .col{
            line-height: 34px;
            height: 34px;
        }

        .panel-table .panel-heading .col h3{
            line-height: 30px;
            height: 30px;
        }

        .panel-table .panel-body .table-bordered > tbody > tr > td{
            line-height: 34px;
        }

        .table tr{
            background-color: white;
        }

        #wrapper {
            margin: 0 0 0 220px;
            padding: 0;
            position: relative;
            min-height: 705px;
            min-width: 1000px;
        }

        /* 토글 버튼용 */
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {display:none;}

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    </style>
</head>

<script>

    // 폴더, 리스트를 저장하기 위한 배열
    var folderListData = new Array();
    var quizlistData = new Array();

    // BODY ONLOAD : 컨트롤러로부터 폴더 정보를 불러오기 위한 AJAX
    function getFolderValue() {

        // 폴더 리스트만 띠우기 위한거기 때문에 folderId 값은 상관없음
        var params = {
            folderId: 0
        };

        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/getfolderLists')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {

                // 최신 폴더 id값
                var index =  data['folders'].length-1;

                //최신 폴더 & 최신 리스트 불러오기
                getFolderListValue(data['folders'][index]['folderId']);
            },
            error: function (data) {
                alert("error");
            }
        });
    }

    // 컨트롤러로부터 폴더 & 리스트 정보를 불러오기 위한 AJAX
    function getFolderListValue(idNum) {

        // 폴더 데이터 초기화
        folderListData = [];

        // 퀴즈 데이터 초기와
        quizlistData = [];

        var params = {
            folderId: idNum
        };

        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/getfolderLists')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {

                folderListData = data;
                quizlistData = data;

                // 공유 폴더일 경우
                if(idNum == 0) listValueS();

                // 공유 폴더가 아닐 경우
                else listValue();
            },
            error: function (data) {
                alert("error");
            }
        });

    }

    // AJAX 통신 성공시 호출되는 메서드 : 폴더, 리스트 정보를 보여줌 (공유폴더 O)
    function listValueS() {

        // 퀴즈 값이 쌓이지 않게 초기화
        $("#list").empty();

        for(var i = 0; i < quizlistData['lists'].length; i++) {

            $("#list").append(
                "<tr>" +
                "<td style='text-align: center'>" +
                "<label class='switch'>" +
                "<input type='checkbox' id='shareToggle' data-toggle='toggle' checked disabled>" +
                "<span class='slider round'></span>" +
                "</label>" +
                "</td>" +
                "<td class='hidden-xs' style='text-align: center'>" + quizlistData['lists'][i]['createdDate']+ "</td>" +
                "<td style='text-align: center'>" +
                "<a href='#showModalFNU" + quizlistData['lists'][i]['listId'] + "' data-toggle='modal' onclick='showList(" + quizlistData['lists'][i]['listId'] + ")'>" + quizlistData['lists'][i]['listName'] + "</a></td>" +
                "<td style='text-align: center'>" + quizlistData['lists'][i]['quizCount'] + "</td>" +
                "<td align='center'>" +
                "<button class='btn btn-default' onclick='shareFolderMsg()'>수정・삭제 불가능</button>" +
                "</td>" +
                "</tr>"
            );
        }
    }

    // AJAX 통신 성공시 호출되는 메서드 : 폴더, 리스트 정보를 보여줌 (공유폴더 X)
    function listValue() {

        // 폴더 & 퀴즈 값이 쌓이지 않게 초기화
        $("#folderList").empty();
        $("#list").empty();

        // <----- 폴더 리스트 ----->
        for(var i = folderListData['folders'].length - 1; i >= 0; i--) {

            if(folderListData['folders'][i]['folderId'] == 0) {
                $("#folderList").append(
                    "<li><a href='#' onclick='getFolderListValue(" + folderListData['folders'][i]['folderId'] + ")'><span class='fa fa-users'></span>" + " " + folderListData['folders'][i]['folderName'] + "</a></li>"
                );
            }
            else {
                $("#folderList").append(
                    "<li><a href='#' onclick='getFolderListValue(" + folderListData['folders'][i]['folderId'] + ")'>" + folderListData['folders'][i]['folderName'] + "</a></li>"
                );

            }
        }

        // <----- 퀴즈 리스트 ----->
        for(var i = 0; i < quizlistData['lists'].length; i++) {

            var toggle = "";

            // 공개된 리스트일 경우, 토글 체크버튼 on
            if(quizlistData['lists'][i]['openState'] == 0) {
                toggle += "<label class='switch'>";
                toggle += "<input type='checkbox' id='test" + quizlistData['lists'][i]['listId'] + "' data-toggle='toggle' checked>";
                toggle += "<span class='slider round'></span>";
                toggle += "</label>";
            }

            // 공개된 리스트가 아닐 경우, 토글 체크버튼 off
            else if(quizlistData['lists'][i]['openState'] == 1) {
                toggle += "<label class='switch'>";
                toggle += "<input type='checkbox' id='test" + quizlistData['lists'][i]['listId'] + "' data-toggle='toggle'>";
                toggle += "<span class='slider round'></span>";
                toggle += "</label>";
            }

            // 1. 레이스로 활용되지 않은 문제만 수정・삭제 가능
            // showQuizDiv Modal 호출
            if(quizlistData['lists'][i]['races'].length == 0) {
                $("#list").append(
                    "<tr>" +
                    "<td style='text-align: center'>" +
                    toggle +
                    "</td>" +
                    "<td class='hidden-xs' style='text-align: center'>" + quizlistData['lists'][i]['createdDate'] + "</td>" +
                    "<td style='text-align: center'>" +
                    "<a href='#showModal" + quizlistData['lists'][i]['listId'] + "' data-toggle='modal' onclick='showList(" + quizlistData['lists'][i]['listId'] + ")'>" + quizlistData['lists'][i]['listName'] + "</a></td>" +
                    "<td style='text-align: center'>" + quizlistData['lists'][i]['quizCount'] + "</td>" +
                    "<td align='center'>" +
                    "<a class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" + quizlistData['lists'][i]['listId'] + "'><em class='fa fa-trash'></em></a>" +
                    "</td>" +
                    "</tr>"
                );

                // 퀴즈 삭제 모달창 띠우기
                $("#deleteQuizDiv").append(
                    "<div class='modal fade' id='deleteModal" + quizlistData['lists'][i]['listId'] + "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>" +
                    "<div class='modal-dialog' role='document'>" +
                    "<div class='modal-content'>" +
                    "<div class='modal-header' style='text-align: center'>" +
                    "<h5 class='modal-title' id='ModalLabel'>[" + quizlistData['lists'][i]['listName'] +"]</h5>" +
                    "</div>" +
                    "<div class='modal-body' style='text-align: center'>퀴즈를 삭제하시겠습니까?" +
                    "</div>" +
                    "<div class='modal-footer'>" +
                    "<button type='button' class='btn btn-primary' onclick='deleteList(" + quizlistData['lists'][i]['listId'] + ")'>삭제하기</button>" +
                    "<button type='button' class='btn btn-secondary' data-dismiss='modal'>취소</button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );

            }

            // 2. 레이스로 활용된 문제 : 수정 삭제 불가능 -> 대신에 누가 언제 사용했는지 나타낼 것
            // showQuizDivFNU Modal 호출
            else {
                $("#list").append(
                    "<tr>" +
                    "<td style='text-align: center'>" +
                    toggle +
                    "</td>" +
                    "<td class='hidden-xs' style='text-align: center'>" + quizlistData['lists'][i]['createdDate']+ "</td>" +
                    "<td style='text-align: center'>" +
                    "<a href='#showModalFNU" + quizlistData['lists'][i]['listId'] + "' data-toggle='modal' onclick='showList(" + quizlistData['lists'][i]['listId'] + ")'>" + quizlistData['lists'][i]['listName'] + "</a></td>" +
                    "<td style='text-align: center'>" + quizlistData['lists'][i]['quizCount'] + "</td>" +
                    "<td align='center'>" +
                    "<button class='btn btn-default' onclick='impossibleMessage(" + i + ")'>수정・삭제 불가능</button>" +
                    "</td>" +
                    "</tr>"
                );
            }


            // 토글 버튼 : 공개 여부
            /* ★★★토글 테스트★★★ */
//                $("#test").change(function () {
//                    if ($(this).is(':checked')) alert(0);
//                    else alert(1);
//                });

            $("#test" + quizlistData['lists'][i]['listId']).change(function () {

                // 공개 버튼(on) 눌렀을 경우
                if($(this).is(':checked')) {

                    var params = {
                        listId: quizlistData['lists'][0]['listId']
                    };

                    $.ajax({
                        type: 'POST',
                        url: "{{url('quizTreeController/updateOpenState')}}",
                        //processData: false,
                        //contentType: false,
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        //data: {_token: CSRF_TOKEN, 'post':params},
                        data: params,
                        success: function (data) {
                            //alert(JSON.stringify(data));
                            alert("공개 ON");
                        },
                        error: function (data) {
                            alert("error");
                        }
                    });
                }

                // 공개 버튼(off) 눌렀을 경우
                else {

                    var params = {
                        listId: quizlistData['lists'][0]['listId']
                    };

                    $.ajax({
                        type: 'POST',
                        url: "{{url('quizTreeController/updateOpenState')}}",
                        //processData: false,
                        //contentType: false,
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        //data: {_token: CSRF_TOKEN, 'post':params},
                        data: params,
                        success: function (data) {
                            //alert(JSON.stringify(data));
                            alert("공개 OFF");
                        },
                        error: function (data) {
                            alert("error");
                        }
                    });
                }

            });
        }
    }

    // ALERT (수정 삭제 불가능한 이유 : 공유 폴더)
    function shareFolderMsg() {
        alert("공유 폴더에 있는 리스트는 삭제할 수 없습니다.");
    }

    // ALERT (수정 삭제 불가능한 이유 : 언제 누가 사용했는지?)
    function impossibleMessage(idNum) {

        var raceInfoData = quizlistData['lists'][idNum]['races'];
        var raceSaveData = new Array();

        for(var i = 0; i < raceInfoData.length; i++) {
            raceSaveData= "플레이 된 리스트는 수정・삭제할 수 없습니다.\n"
                + "- 총 플레이 횟수: " + raceInfoData.length +"회\n"
                + "<최근 플레이 기록>\n"
                + "날짜: " + raceInfoData[i]['date'] + "\n"
                + "클래스: " + raceInfoData[i]['groupName'] + "\n"
                + "선생님: " + raceInfoData[i]['teacherName'];
        }

        alert(raceSaveData);

    }

    // <기능 1> 리스트 생성
    // 입력된 퀴즈명, 폴더 아이디를 컨트롤러로 보내기 위함
    function createList() {
        var folderIdObj = document.getElementById("folderId");
        folderIdObj.value = folderListData["selectFolder"];
    }

    // <추가 기능> 폴더 생성
    var folderName = "";

    $(document).ready(function () {
        $('#folder').change(function () {
            folderName = $("#folder").val();
        })
    });

    function createFolder() {

        var params = {
            folderName: folderName
        };

        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/createFolder')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {

                if(data['check'] == true) window.location.href = "{{url('quiz_list')}}";
            },
            error: function (data) {

                alert("error");
            }
        });
    }

    // <기능 2> 리스트 삭제
    function deleteList(idNum) {

        var params = {
            folderId: folderListData['selectFolder'],
            listId: idNum
        };

        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/deleteList')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {

                if(data['check'] == true) {
                    window.location.href = "{{url('quiz_list')}}"
                };
            },
            error: function (data) {

                alert("error");
            }
        });
    }

    var showListData = new Array();

    // <기능 3> 리스트 미리보기
    function showList(idNum) {

        var params = {
            listId: idNum
        };

        $.ajax({
            type: 'POST',
            url: "{{url('quizTreeController/showList')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {

                showListData = data;

                //alert(JSON.stringify(showListData));
                //alert(JSON.stringify(folderListData['selectFolder']));
                //alert(JSON.stringify(showListData['quizs'].length));

                var str = "";
                var questionId = 0;

                for(var i = showListData['quizs'].length-1 ; i >= 0 ; i--) {

                    questionId++;

                    if(showListData['quizs'][i]['hint'] == null) showListData['quizs'][i]['hint'] = "";
                    if(showListData['quizs'][i]['example1'] == null) showListData['quizs'][i]['example1'] = "";
                    if(showListData['quizs'][i]['example2'] == null) showListData['quizs'][i]['example2'] = "";
                    if(showListData['quizs'][i]['example3'] == null) showListData['quizs'][i]['example3'] = "";
                    if(showListData['quizs'][i]['quizType'] == "vocabulary") showListData['quizs'][i]['quizType'] = "어휘";
                    if(showListData['quizs'][i]['quizType'] == "word") showListData['quizs'][i]['quizType'] = "단어";
                    if(showListData['quizs'][i]['quizType'] == "grammar") showListData['quizs'][i]['quizType'] = "문법";

                    if(showListData['quizs'][i]['makeType'] == "obj") {
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
                        str += "<td style='background-color: #EAEAEA'>" +  showListData['quizs'][i]['right'] + "</td>";
                        str += "<td>" +  showListData['quizs'][i]['example1'] + "</td>";
                        str += "<td>" +  showListData['quizs'][i]['example2'] + "</td>";
                        str += "<td>" +  showListData['quizs'][i]['example3'] + "</td>";
                        str += "</tr>";
                        str += "</table>";
                    }

                    else if(showListData['quizs'][i]['makeType'] == "sub") {
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
                        str += "<td colspan='2' style='background-color: #EAEAEA;'>" +  showListData['quizs'][i]['right'] + "</td>";
                        str += "<td colspan='2'><힌트> " +  showListData['quizs'][i]['hint'] + "</td>";
                        str += "</tr>";
                        str += "</table>";
                    }
                }

                $("#showQuizDiv").append(
                    "<div class='modal fade' id='showModal" + idNum + "' tabindex='-1'>" +
                    "<div class='modal-dialog modal-lg'>" +

                    // MODAL content
                    "<div class='modal-content'>" +
                    "<div class='modal-header' style='text-align: center'>" +
                        "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>" +
                        "<h4 class='modal-title'>퀴즈명 : " + showListData['listName'] + "</h4>" +
                    "</div>" +

                    "<div class='modal-body'>" +
                        // 퀴즈 미리보기 : 문제 내용
                        "<div>" +
                        str +
                        "</div>" +
                    "</div>" +

                    "<div class='modal-footer'>" +
                        // 퀴즈 수정하기
                        "<button type='submit' class='btn btn-default' onclick='sendId(" + idNum + ")'><em class='fa fa-pencil'></em></button>" +
                        "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );

                $("#showQuizDivFNU").append(
                    "<div class='modal fade' id='showModalFNU" + idNum + "' tabindex='-1'>" +
                    "<div class='modal-dialog modal-lg'>" +

                    // MODAL content
                    "<div class='modal-content'>" +
                    "<div class='modal-header' style='text-align: center'>" +
                    "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>" +
                    "<h4 class='modal-title'>퀴즈명 : " + showListData['listName'] + "</h4>" +
                    "</div>" +

                    "<div class='modal-body'>" +
                    // 퀴즈 미리보기 : 문제 내용
                    "<div>" +
                    str +
                    "</div>" +
                    "</div>" +

                    "<div class='modal-footer'>" +
                    "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );

            },
            error: function (data) {
                alert("error");
            }
        });

    }

    // 리스트 수정용 : <form> updateList로 listId값 보내기
    function sendId(listId) {
        var updateListIdObj = document.getElementById("updateListId");
        updateListIdObj.value = listId;
    }

</script>


<body onload="getFolderValue()">

<nav>
    @include('Navigation.main_nav')
</nav>

<div class="row">
    <div class="side-menu">
        <aside class="navbar navbar-default" role="navigation">
        @include('QuizTree.quiz_list_sidebar')
    </aside>
    </div>

    <div class="btn-process" style="margin-top:50px;"></div>

    <!--Quiz List Table-->
    <div id="wrapper">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6" id="showFolderName">
                            <!-- FolerName 공간 -->
                        </div>
                        <!-- Create quiz -->
                        <form action="{{url('quizTreeController/createList')}}" method="Post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="folderId" id="folderId" value="">
                            <div class="col col-xs-6 text-right" id="quizButton">
                                <!-- Quiz Button 공간 -->
                                <button type="submit" class="btn btn-sm btn-primary btn-create" onclick="createList()">퀴즈 만들기</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th style="width: 10%">공개여부</th>
                            <th class="hidden-xs" style="text-align: center; width: 20%">등록일</th>
                            <th style="text-align: center; width: 50%;">퀴즈명</th>
                            <th style="text-align: center; width: 10%;">문항수</th>
                            <th style="width: 10%; text-align: center"><em class="fa fa-cog"></em></th>
                        </tr>
                        </thead>
                        <tbody id="list">
                        <!-- list 공간 -->
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page 1 of 5
                        </div>
                        <div class="col col-xs-8">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal : delete quiz-->
<div id="deleteQuizDiv"></div>

<!--Modal : update quiz-->
<form action="{{url('quizTreeController/updateList')}}" method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="listId" id="updateListId" value="">
    <!--Modal : show quiz-->
    <div id="showQuizDiv"></div>
</form>

<!--Modal : show quiz (수정 불가 리스트)-->
<div id="showQuizDivFNU"></div>

<!--Modal : create folder-->
<div class="modal fade" id="createFolder">
    <div class="modal-dialog">
        <input type="hidden" name="folderName" id="folderName" value="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">폴더 만들기</h5>
            </div>
            <div class="modal-body" style="text-align: center">
                폴더 이름 <input type="text" id="folder" value="">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="createFolder()">만들기</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
