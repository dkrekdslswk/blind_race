<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz list</title>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>

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
                folderListData = data;
                quizlistData = data;
                alert(JSON.stringify(folderListData));
                // 폴더 리스트
                folderValue();

                // 최신 퀴즈 리스트
                //getListValue(folderListData['folders'][0]['folderId']);
            },
            error: function (data) {
                alert("error");
            }
        });

    }

    // 컨트롤러로부터 리스트 정보를 불러오기 위한 AJAX
    function getListValue(idNum) {

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
                quizlistData = data;
                listValue();
            },
            error: function (data) {
                alert("error");
            }
        });

    }

    // AJAX 통신 성공시 호출되는 메서드 : 폴더 정보를 보여줌
    function folderValue() {
        for(var i = 0; i < folderListData['folders'].length; i++) {
            if(folderListData['folders'][i]['folderId'] == 0) {
                $("#folderList").append(
                    "<li><a href='#' onclick='getListValue(" + folderListData['folders'][i]['folderId'] + ")'><span class='glyphicon glyphicon-folder-open'></span>" + folderListData['folders'][i]['folderName'] + "</a></li>"
                );
            }
            else {
                $("#folderList").append(
                    "<li><a href='#' onclick='getListValue(" + folderListData['folders'][i]['folderId'] + ")'><span class='glyphicon glyphicon-folder-close'></span>" + folderListData['folders'][i]['folderName'] + "</a></li>"
                );

            }
        }
    }

    // AJAX 통신 성공시 호출되는 메서드 : 리스트 정보를 보여줌
    function listValue() {

        $("#list").empty();

        for(var i = 0; i < quizlistData['lists'].length; i++) {

            // 1. 레이스로 활용되지 않은 문제만 수정・삭제 가능
            // showQuizDiv Modal 호출
            if(quizlistData['lists'][i]['races'].length == 0) {
                $("#list").append(
                    "<tr>" +
                    "<td align='center'>" +
                    "<a class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" + quizlistData['lists'][i]['listId'] + "'><em class='fa fa-trash'></em></a>" +
                    "</td>" +
                    "<td class='hidden-xs' style='text-align: center'>" + quizlistData['lists'][i]['createdDate'] + "</td>" +
                    "<td style='text-align: center'>" +
                    "<a href='#showModal" + quizlistData['lists'][i]['listId'] + "' data-toggle='modal' onclick='showList(" + quizlistData['lists'][i]['listId'] + ")'>" + quizlistData['lists'][i]['listName'] + "</a></td>" +
                    "<td style='text-align: center'>" + quizlistData['lists'][i]['quizCount'] + "</td>" +
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
                    "<td align='center'>" +
                    "<button class='btn btn-default' onclick='impossibleMessage(" + i + ")'>수정・삭제 불가능</button>" +
                    "</td>" +
                    "<td class='hidden-xs' style='text-align: center'>" + quizlistData['lists'][i]['createdDate']+ "</td>" +
                    "<td style='text-align: center'>" +
                    "<a href='#showModalFNU" + quizlistData['lists'][i]['listId'] + "' data-toggle='modal' onclick='showList(" + quizlistData['lists'][i]['listId'] + ")'>" + quizlistData['lists'][i]['listName'] + "</a></td>" +
                    "<td style='text-align: center'>" + quizlistData['lists'][i]['quizCount'] + "</td>" +
                    "</tr>"
                );
            }
        }
    }

    // ALERT (수정 삭제 불가능한 이유 : 언제 누가 사용했는지?)
    function impossibleMessage(idNum) {

        var raceInfoData = quizlistData['lists'][idNum]['races'];
        var raceSaveData = new Array();

        for(var i = 0; i < raceInfoData.length; i++) {
            raceSaveData= "플레이 된 레이스는 수정・삭제 할 수 없습니다.\n"
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
    $(document).ready(function () {
        $('#quizName').change(function () {
            var quizName = $("#quizName").val();

            var listNameObj = document.getElementById("listName");
            listNameObj.value = quizName;

            var folderIdObj = document.getElementById("folderId");
            folderIdObj.value = folderListData["selectFolder"];
        });
    });

    // <추가 기능> 폴더 생성
    /*$(document).ready(function () {
        $('#folder').change(function () {
            var folderName = $("folder").val();

            var folderNameObj = document.getElementById("folderName");
            folderNameObj.value = folderName;
        })
    });*/

    // <추가 기능> 폴더 생성
    function createFolder() {

        var params = {
            folderName: "test2"
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

                if(data['check'] == true) window.location.href = "{{url('quiz_list')}}";
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
                        "<button type='submit' class='btn btn-default' onclick='sendId(" + idNum +")'><em class='fa fa-pencil'></em></button>" +
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
        @include('QuizTree.quiz_list_side_bar')
    </aside>
    </div>

    <div class="btn-process" style="margin-top:50px;"></div>

    <!--Quiz List Table-->
    <div id="wrapper">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">퀴즈 리스트</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#Modal">퀴즈 만들기</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th style="width: 15%;"><em class="fa fa-cog"></em></th>
                            <th class="hidden-xs" style="text-align: center; width: 20%">등록일</th>
                            <th style="text-align: center; width: 50%;">퀴즈명</th>
                            <th style="text-align: center; width: 15%;">문항수</th>
                        </tr>
                        </thead>
                        <tbody id="list">
                        {{--list 공간--}}
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

<!--Modal : create quiz-->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('quizTreeController/createList')}}" method="Post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="listName" id="listName" value="">
            <input type="hidden" name="folderId" id="folderId" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">퀴즈 만들기</h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    퀴즈 이름 <input type="text" id="quizName">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">만들기</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </form>
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
<div id="createFolderDiv"></div>
    <div class="modal fade" id="createFolder">
        <div class="modal-dialog">
            <input type="hidden" name="folderName" id="folderName" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">폴더 만들기</h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    폴더 이름 <input type="text" id="folder">
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
