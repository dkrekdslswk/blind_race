<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        body {
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #f7f8fa;
            font-size: 13px;
            color: #5f5f5f;
            margin: 0;
            padding: 0;
        }
        body.disabled { overflow: hidden; }

        .main-body {
            max-width: 1220px;
            min-width: 955px;
            /*     overflow: hidden; */
            margin: 0 auto;
            position: relative;
            height: 1024px;
        }
        .page-small .main-body {
            max-width: 768px;
            min-width: 320px;
        }


        #wrapper {
            margin: 0 0 0 220px;
            padding: 0;
            position: relative;
            /*     min-height: 100% */
            min-height: 705px;
            min-width: 1000px;
        }

        #menu-main {
            width: 220px;
            hegight:100%;
            left: 0;
            bottom: 0;
            float: left;
            position: relative;
            /*     min-height: 1000px; */
            top: 0px;
            transition: all 0.4s ease 0s;
            background-color: #ffffff;
            border-left: 1px solid #e1e2e3;
            border-right: 1px solid #e1e2e3;
            border-bottom: 1px solid #e1e2e3;
        }

        #group_chart, #record_history , #record_students, #record_feedback {
            margin-left: 10px;
            margin-right: 10px;
            min-height: 700px;
            min-width: 700px;
            display: block;
        }

        #wrong_detail tr , #details_record tr , #wrongQuestions tr{
            border-bottom: 1px solid #e5e6e8;
        }

        #wrong_detail tr td , #details_record tr td , #wrongQuestions tr td {
            border-left: 1px solid #e5e6e8;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <script type="text/javascript">

        var chartData = "";
        var group_id = 0;
        var loadDt = new Date();

        // 1~9월 1~9일에 앞자리 0추가해주는 함수
        function fn_leadingZeros(n, digits) {

            var zero = '';
            n = n.toString();

            if (n.length < digits) {
                for (var i = 0; i < digits - n.length; i++){ zero += '0'; }
            }
            return zero + n;
        }

        // 날짜의 포맷을 ( YYYY-mm-dd ) 형태로 만들어줍니다.
        var defaultEndDate = loadDt.getFullYear() + '-' + fn_leadingZeros(loadDt.getMonth() + 1, 2) + '-' + fn_leadingZeros(loadDt.getDate(), 2);
        var tempdate = new Date(defaultEndDate);
            tempdate.setMonth(tempdate.getMonth()-1);
        var defaultStartDate = tempdate.getFullYear() + '-' + fn_leadingZeros(tempdate.getMonth() + 1, 2) + '-' + fn_leadingZeros(tempdate.getDate(), 2);

        //처음 화면 로드
        window.onload = function() {

            //클래스 불러오기 and 차트 로드하기
            pageMainLoad();
        };

        //메인 페이지 로드
        function pageMainLoad(){

            /*part.1 사이드바*/
            //클래스 불러오기 and 차트 로드하기 -> record_chart.blade.php
            getGroups_and_loadChart(1);

        }

        //최근기록 페이지 로드
        function pageHistoryLoad(){

            /*part.2 최근기록 화면*/
            //최근 목록 불러오기


        }

        //피드백 페이지 로드
        function pageFeedbackLoad(){

            /*part.5 피드백 화면*/
            //차트 만들기 실행 -> record_chart.blade.php

        }

        //클래스 클릭 할 때 마다 메인 페이지(차트) 로드
        $(document).on('click','.groups',function () {

            var reqGroupId = $(this).attr('id');

            group_id = reqGroupId;

            var reqGroupName = $(this).attr('name');

            getChartData_and_loadChart(reqGroupId,defaultStartDate,defaultEndDate);
            getStudents(reqGroupId);
            getHistory(reqGroupId);

        });

        //날짜 타입 라디오 버튼 누를때 마다 차트에 반영
        function changeDateToChart(){

            var selectedradio = $("input[type=radio][name=optradio]:checked").val();
            var startDate = "";

            function caldate(day){

                var caledmonth, caledday, caledYear;
                var v = new Date(Date.parse(loadDt) - day*1000*60*60*24);

                caledYear = v.getFullYear();

                if( v.getMonth() < 9 ){
                    caledmonth = '0'+(v.getMonth()+1);
                }else{
                    caledmonth = v.getMonth()+1;
                }

                if( v.getDate() < 9 ){
                    caledday = '0'+v.getDate();
                }else{
                    caledday = v.getDate();
                }
                return caledYear+"-"+caledmonth+'-'+caledday;
            }

            switch (selectedradio) {
                case "1":
                    startDate = caldate(7);
                    break;

                case "2":
                    startDate = caldate(30);
                    break;

                case "3":
                    startDate = caldate(90);
                    break;

                case "4":
                    startDate = caldate(180);
                    break;

                case "5":
                    startDate = caldate(365);
                    break;
            }

            getChartData_and_loadChart(group_id,startDate,defaultEndDate);
        }

        function orderChart(){
            var startDate = document.querySelector('input[id="startDate"]').value;
            var endDate = document.querySelector('input[id="endDate"]').value;

            getChartData_and_loadChart(group_id,startDate,endDate);
        }

        //날짜를 가져와서 조회 및 차트 그리기
        function getChartData_and_loadChart(groupId,startDate,endDate){

            $('#'+groupId).css('background-color','#d9edf7');

            var requestData = {"groupId" : groupId , "startDate" : startDate , "endDate" : endDate};
            /*var group_Id = {"groupId" : 1 , "startDate" : "2018-05-01" , "endDate" : "2018-05-08"};*/

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getChart')}}",
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: requestData,
                success: function (data) {

                    /*
                    * data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 : {  year:2018
                                                month:5
                                                day:11

                                                raceId:2
                                                listName:"테스트용 리스트1"
                                                userCount:5

                                                quizCount:6
                                                rightAnswerCount:4

                                                grammarCount:2
                                                grammarRightAnswerCount:1.4

                                                vocabularyCount:2
                                                vocabularyRightAnswerCount:1.2

                                                wordCount:2
                                                wordRightAnswerCount:1.4
                                              }
                                        }
                    */

                    chartData = data['races'];

                    //레코드 네비바 클래스 이름과 아이디와 내용 바꾸기
                    $('#nav_group_name').text(data['group']['name']);

                    var ChartData = makingChartData(data);
                    makingChart(ChartData);

                },
                error: function (data) {
                    alert("날짜 조회 에러");
                }
            });

        }

        //클래스 가져오기
        //차트 그리기
        //학생 명단 가져오기
        function getGroups_and_loadChart(groupId) {

            $.ajax({
                type: 'POST',

                url: "{{url('/groupController/groupsGet')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: groupId,
                success: function (data) {

                    var GroupData = data;

                    for( var i = 0 ; i < GroupData['groups'].length ; i++ ){

                        $('#group_names').append($('<a href="#">')
                            .append($('<div class="groups" name="'+GroupData['groups'][i].groupName+'" id="'+ GroupData['groups'][i].groupId +'">')
                                .text(GroupData['groups'][i].groupName)));

                    }

                    //가장 상단에 위치한 클래스
                    var firstGroup = $('.groups:first-child');

                    //레코드박스네비바 첫부분에 상단 클래스 이름 넣기
                    $('#nav_group_name').text(firstGroup.attr('name'));

                    //가장 상단에 있는 클래스 ID값으로 차트 만들기
                    getChartData_and_loadChart(firstGroup.attr('id'),defaultStartDate,defaultEndDate);
                    getStudents(firstGroup.attr('id'));
                    getHistory(firstGroup.attr('id'));

                    group_id = firstGroup.attr('id');

                },
                error: function (data) {
                    alert("그룹겟 에러");
                }
            });

        }

        //그룹에 속한 학생들 가져오기
        //최근기록 -> 성적표(토글)페이지
        //학생관리 ->
        function getStudents(groupId){

            var reqData ={"groupId" : groupId};

            $.ajax({
                type: 'POST',

                url: "{{url('/groupController/groupDataGet')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: reqData,
                success: function (data) {

                    $('#student_list').empty();

                    /*
                    data = {group : { id: 1, name: "#WDJ", studentCount : 5}
                            student : { 0: { id: 1300000, name: "김똘똘"}
                                        1: { id: 1300000, name: "최천재"}
                                       }
                            teacher : { id: 123456789, name: "이OO교수"}
                    */

                    var student = data['students'];

                    for(var i = 0 ; i < student.length; i++){
                        $('#student_list').append($('<tr id="student_list_'+i+'">'));

                        for(var j = 0 ; j < 1 ; j++ ) {

                            $('#student_list_' + i).append($('<td>').text(i+1));
                            $('#student_list_' + i).append($('<td>')
                                                    .append($('<a href="#">')
                                                        .text(student[i]['name']))
                                                    .attr('id',student[i]['id'])
                                                    .attr('name',student[i]['name'])
                                                    .attr('class','stdList'));
                        }
                    }


                },
                error: function (data) {
                    alert("그룹에 속한 학생 에러");
                }
            });

        }

        $("input[name=studentOrGrade]:checked").change(function () {

            if($("input[name=studentOrGrade]:checked").is(":checked")){
                alert("체크박스 체크했음!");
            }else{
                alert("체크박스 체크 해제!");
            }
        });


        function toggle_detailStudent_and_Wrong(value) {

            if($("#checkbox_0").is(":checked")){
                $('#toggle_only_students').attr('class','');
            }else{
                $('#toggle_only_students').attr('class','hidden');
            }

            if($("#checkbox_1").is(":checked")){
                $('#toggle_only_wrong_answers').attr('class','');
            }else{
                $('#toggle_only_wrong_answers').attr('class','hidden');
            }
        };


        function getHistory(group_id){
            // 요구하는 값
            // $postData = array( 'groupId'   => 1 );

            $('#history_list').empty();

            var reqData = {"groupId" : group_id};
            var raceData = [];

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getRaces')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {

                    /*
                     races : { 0 : { raceId: 7,
                                     listName: "테스트용 리스트1",
                                     teacherName: "이교수",
                                     studentCount: 5,

                                     date: "2018-05-13 19:53:47",
                                     year: 2018,
                                     mont: 5,
                                     day: 13,

                                     wrongClearCount: 0
                                     wrongCount: 0
                                     retestClearCount: 0
                                     retestCount: 0
                     */

                    for( var i = 0 ; i < data['races'].length ; i++ ){
                        $('#history_list').append($('<tr>').attr('id','history_list_tr'+i));
                    }

                    for( var i = 0 ; i < data['races'].length ; i++ ){
                        $('#history_list_tr'+i).append($('<td>').text(i+1));
                        $('#history_list_tr'+i).append($('<td>').append($('<a href="#" onclick="checkHomework(this.id)">')
                                                                .attr('id',data['races'][i]['raceId'])
                                                                .text(data['races'][i]['listName'])));

                        $('#history_list_tr'+i).append($('<td>').text(data['races'][i]['date']));
                        $('#history_list_tr'+i).append($('<td>').text(data['races'][i]['retestClearCount']+"/"+data['races'][i]['retestCount']));

                        $('#history_list_tr'+i).append($('<td>').text(data['races'][i]['wrongClearCount']+"/"+data['races'][i]['wrongCount']));

                        $('#history_list_tr'+i).append($('<td>').attr('class','history_list_gradeCard')
                            .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_RaceGradeCard">')
                                .attr('id',data['races'][i]['raceId'])
                            .text("성적표")));

                    }

                },
                error: function (data) {
                    alert("최근 기록 불러오기 실패");
                }
            });


            /*var data = {
                "races": {
                    0 : {
                        "raceId": 2,
                        "listName": "스쿠스쿠3",
                        "date": "2018년 1월 16일",
                        "studentCount": 5,
                        "retestClearCount": 0,
                        "retestCount": 4,
                        "wrongClearCount": 0,
                        "wrongCount": 4,
                    },

                    1 : {
                        "raceId": 1,
                        "listName": "스쿠스쿠4",
                        "date": "2018년 4월 46일",
                        "studentCount": 5,
                        "retestClearCount": 0,
                        "retestCount": 3,
                        "wrongClearCount": 0,
                        "wrongCount": 3,
                    }
                }
            };*/
            /*for(var i = 0 ; i < 2 ; i++ ){
                if (group_id == data['races'][i]['raceId']){
                    raceData = data['races'][i];
                }else {
                    raceData = null;
                }
            }*/

            /*if(raceData != null){
                for( var i = 0 ; i < 1 ; i++ ){
                    $('#history_list').append($('<tr>').attr('id','history_list_tr'+i));
                }

                for( var i = 0 ; i < 1 ; i++ ){
                    $('#history_list_tr'+i).append($('<td>').text(i+1));
                    $('#history_list_tr'+i).append($('<td>').append($('<a href="#" onclick="checkHomework()">').text(raceData['listName'])));

                    $('#history_list_tr'+i).append($('<td>').text(raceData['date']));
                    $('#history_list_tr'+i).append($('<td>').text(raceData['retestClearCount']+"/"+raceData['retestCount']));

                    $('#history_list_tr'+i).append($('<td>').text(raceData['wrongClearCount']+"/"+raceData['wrongCount']));

                    $('#history_list_tr'+i).append($('<td>').append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">').text("성적표")));

                }
            }*/


        }

        //레코드리스트에서 성적표 클릭시 성적표 로드
        $(document).on('click','.history_list_gradeCard button',function () {
            loadGradeCard(this.id);
        });

        //학생 상세정보에서 성적표 클릭시 성적표 로드
        $(document).on('click','.modal_openStudentGradeCard button',function () {
            var raceId = $(this).attr('id');
            var userId = $(this).attr('name');

            loadStudentGradeCard(userId,raceId);
        });

        //학생 상세정보에서 재시험 클릭시 성적표 로드
        $(document).on('click','.modal_openStudentRetestGradeCard button',function () {
            var raceId = $(this).attr('id');
            var userId = $(this).attr('name');

            console.log(userId,raceId);
            loadStudentGradeCard(userId,raceId);
            getRetestData();
        });

        //학생 상세정보에서 오답노트 클릭시 성적표 로드
        $(document).on('click','.modal_openStudentWrongGradeCard button',function () {
            var raceId = $(this).attr('id');
            var userId = $(this).attr('name');

            getStudentWrongWriting(userId,raceId);
        });


        //성적표 출력
        function loadGradeCard(value){

            //value = {userId : 1300000}
            //value = {raceId : 1}

            var reqData = {'raceId' : value};

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getStudents')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {
                    /*
                     data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 : {  year:2018,
                                                month:5,
                                                day:11,
                                                date: "2018-05-07 19:53:46",

                                                raceId:1,
                                                listName:"테스트용 리스트1",
                                                userCount:5,
                                                userName:"김똘똘",
                                                userId: 1300000,
                                                teacherName: "이OO교수",

                                                allCount:6,
                                                allRightCount:4,

                                                grammarCount:2,
                                                grammarRightAnswerCount:1.4,

                                                vocabularyCount:2,
                                                vocabularyRightAnswerCount:1.2,

                                                wordCount:2,
                                                wordRightAnswerCount:1.4,

                                                retestState:"not",
                                                wrongState:"not"
                                              }
                                        }
                    */

                    var StudentData = data['races'];
                    var StudentScore = makingStudentChartData(data);
                    var totalGrade = 0;
                    var totalVoca = 0;
                    var totalGrammer = 0;
                    var totalWord = 0;
                    var totalRight = 0;

                    $('#modal_raceName_teacher').empty();
                    $('.modal_date').empty();
                    $('.modal #grade_list').empty();
                    $('#modal_total_grade').empty();
                    $('#toggle_student_list').empty();
                    $('#toggle_wrong_answers').empty();

                    $('#modal_raceName_teacher').text(StudentData[0]['listName'] +"  /  " +StudentData[0]['teacherName'] );
                    $('.modal_date').text(StudentData[0]['year']+"년 "+StudentData[0]['month']+"월 "+StudentData[0]['day']+"일");


                    for(var i = 0 ; i < StudentData.length ; i++){
                        $('.modal #grade_list').append($('<tr>').attr('id', 'modal_Grade_'+i));

                        $('#modal_Grade_' + i).append($('<td>').text(StudentData[i]['userName']));
                        $('#modal_Grade_' + i).append($('<td>').text(StudentScore['total_data'][1][i]['y']));
                        $('#modal_Grade_' + i).append($('<td>').text(StudentScore['voca_data'][1][i]['y']));
                        $('#modal_Grade_' + i).append($('<td>').text(StudentScore['grammer_data'][1][i]['y']));
                        $('#modal_Grade_' + i).append($('<td>').text(StudentScore['word_data'][1][i]['y']));
                        $('#modal_Grade_' + i).append($('<td>').text(StudentData[i]['allRightCount']+"/"+StudentData[i]['allCount']));

                        //시험친 학생들 명단 출력
                        $('#toggle_student_list').append($('<tr id="toggle_student_list'+i+'">'));

                        $('#toggle_student_list' + i).append($('<td>').text(i+1));
                        $('#toggle_student_list' + i).append($('<td>')
                            .append($('<a href="#" onclick="getWrongAnswer('+StudentData[i]['userId']+','+StudentData[i]['raceId']+')">')
                                .text(StudentData[i]['userName']))
                            .attr('id',StudentData[i]['userId'])
                            .attr('name',StudentData[i]['userName'])
                            .attr('class','toggle_stdList'));


                        totalGrade += StudentScore['total_data'][1][i]['y'];
                        totalVoca += StudentScore['voca_data'][1][i]['y'];
                        totalGrammer += StudentScore['grammer_data'][1][i]['y'];
                        totalWord += StudentScore['word_data'][1][i]['y'];
                        totalRight += StudentData[i]['allRightCount'];
                    }

                    //modal-footer 총 점수들 표시
                    $('#modal_total_grade').text("전체 평균: "+parseInt(totalGrade / StudentData.length)+
                                                " / 어휘: "+parseInt(totalVoca / StudentData.length)+
                                                " / 문법: "+parseInt(totalGrammer / StudentData.length)+
                                                " / 독해: "+parseInt(totalWord / StudentData.length)+
                                                " / 갯수: "+parseInt(totalRight / StudentData.length));

                    //틀린 오답문제들 전부 로드하기
                    getRaceWrongAnswer(StudentData[0]['raceId']);
                },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }
            });
        }

        function loadStudentGradeCard(userId,raceId){
            //value = {userId : 1300000}
            //value = {raceId : 1}

            var reqData = {'raceId' : raceId};

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getStudents')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {
                    /*
                     data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 : {  year:2018,
                                                month:5,
                                                day:11,
                                                date: "2018-05-07 19:53:46",

                                                raceId:1,
                                                listName:"테스트용 리스트1",
                                                userCount:5,
                                                userName:"김똘똘",
                                                userId: 1300000,
                                                teacherName: "이OO교수",

                                                allCount:6,
                                                allRightCount:4,

                                                grammarCount:2,
                                                grammarRightCount:1.4,

                                                vocabularyCount:2,
                                                vocabularyRightCount:1.2,

                                                wordCount:2,
                                                wordRightCount:1.4,

                                                retestState:"not",
                                                wrongState:"not"
                                              }
                                        }
                    */

                    var StudentData;

                    for(var i = 0 ; i < data['races'].length ; i++){
                        if (userId == data['races'][i]['userId']){
                            StudentData = data['races'][i];
                        }
                    }

                    $('#modal_student_raceName_teacher').empty();
                    $('.modal_student_date').empty();
                    $('.modal #studentGradeCard').empty();

                    $('#modal_student_raceName_teacher').text(StudentData['listName'] +"  /  " +StudentData['teacherName'] );
                    $('.modal_student_date').text(StudentData['year']+"년 "+StudentData['month']+"월 "+StudentData['day']+"일");


                    for(var i = 0 ; i < 1 ; i++){
                        $('.modal #studentGradeCard').append($('<tr>').attr('id', 'modal_stdGrade_'+i));

                        $('#modal_stdGrade_' + i).append($('<td>').text(StudentData['userName']));
                        $('#modal_stdGrade_' + i).append($('<td>').text(parseInt((100 / StudentData['allCount']) * StudentData['allRightCount'])));
                        $('#modal_stdGrade_' + i).append($('<td>').text(parseInt((33 / StudentData['vocabularyCount']) * StudentData['vocabularyRightCount'])));
                        $('#modal_stdGrade_' + i).append($('<td>').text(parseInt((33 / StudentData['grammarCount']) * StudentData['grammarRightCount'])));
                        $('#modal_stdGrade_' + i).append($('<td>').text(parseInt((33 / StudentData['wordCount']) * StudentData['wordRightCount'])));
                        $('#modal_stdGrade_' + i).append($('<td>').text(StudentData['allRightCount']+"/"+StudentData['allCount']));

                    }

                    $('#details_record').empty();
                    getStudentWrongAnswer(userId,raceId);

                },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }
            });
        }

        function getWrongAnswer(userId,raceId) {

            var reqData ={"userId" : userId , "raceId" : raceId};

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getWrongs')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {
                    /*
                     data = { wrongs: {
                                    0: { number: 1,
                                        id: 1,
                                        question: "苦労してためたお金なのだから、一円（　　）無駄には使いたくない。",
                                        hint:"3",

                                        rightAnswer:1,
                                        example1:"たりとも",
                                        example2:"とはいえ",
                                        example3:"だけさえ",

                                        userCount:1,
                                        rightAnswerCount:0,
                                        wrongCount:1,
                                        example1Count:0,
                                        example2Count:0,
                                        example3Count:1,
                                        }
                                    }
                            }
                    */

                    $('#toggle_wrong_answers').empty();

                    var wrongsData = data['wrongs'];

                    for(var i = 0 ; i < wrongsData.length ; i++ ){

                        for(var j = 0 ; j < 3 ; j++) {
                            $('#toggle_wrong_answers').append($('<tr>').attr('id', 'toggle_wrong_'+wrongsData[i]['number']+"_"+ j));

                            switch (j) {
                                case 0 :
                                    $('#toggle_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['number']).attr('rowSpan',3));
                                    $('#toggle_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['question']).attr('colSpan',2));

                                    break;
                                case 1 :
                                    $('#toggle_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_'+wrongsData[i]['number']+"_"+0));
                                    $('#toggle_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_'+wrongsData[i]['number']+"_"+1));

                                    break;
                                case 2 :
                                    $('#toggle_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_'+wrongsData[i]['number']+"_"+2));
                                    $('#toggle_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_'+wrongsData[i]['number']+"_"+3));
                                    break;
                            }
                        }

                        for(var j = 0 ; j < 4 ; j++){

                            if (j == 0){
                                $('#wrong_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['rightAnswer']).css('background-color','#ffa500');

                            }else{
                                $('#wrong_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['example'+j]);

                                if(wrongsData[i]['example'+j+'Count'] == 1){
                                    $('#wrong_'+wrongsData[i]['number']+"_"+ j).css('background-color','#e5e6e8');
                                }

                            }
                        }

                    }

                },
                error: function (data) {
                    alert("해당 학생별 오답 문제 가져오기");
                }
            });

        }

        //해당 레이스안에서 나온 오답들 가져오기
        function getRaceWrongAnswer(raceId) {

            var reqData ={"raceId" : raceId};

            console.log(reqData);

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getWrongs')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {
                    /*
                     data = { wrongs: {
                                    0: { number: 1,
                                        id: 1,
                                        question: "苦労してためたお金なのだから、一円（　　）無駄には使いたくない。",
                                        hint:"3",

                                        rightAnswer:1,
                                        example1:"たりとも",
                                        example2:"とはいえ",
                                        example3:"だけさえ",

                                        userCount:5,
                                        rightAnswerCount:0,
                                        wrongCount:5,
                                        example1Count:0,
                                        example2Count:3,
                                        example3Count:2,
                                        }
                                    }
                            }
                    */

                    $('#wrong_detail').empty();

                    var wrongsData = data['wrongs'];

                    for(var i = 0 ; i < wrongsData.length ; i++ ){

                        for(var j = 0 ; j < 3 ; j++) {
                            $('#wrong_detail').append($('<tr>').attr('id', 'toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j));

                            switch (j) {
                                case 0 :
                                    $('#toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['number']).attr('rowSpan',3));
                                    $('#toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['question']).attr('colSpan',2));
                                    $('#toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['rightAnswerCount']+" / "+wrongsData[i]['userCount']).attr('rowSpan',3));

                                    break;
                                case 1 :
                                    $('#toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_detail_'+wrongsData[i]['number']+"_"+0));
                                    $('#toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_detail_'+wrongsData[i]['number']+"_"+1));

                                    break;
                                case 2 :
                                    $('#toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_detail_'+wrongsData[i]['number']+"_"+2));
                                    $('#toggle_wrong_detail_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrong_detail_'+wrongsData[i]['number']+"_"+3));
                                    break;
                            }
                        }

                        for(var j = 0 ; j < 4 ; j++){

                            //정답 부분은 색깔 주기
                            if (j == 0){
                                $('#wrong_detail_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['rightAnswer']).css('background-color','#ffa500');

                            }else {
                                //지문에 오답자가 한명도 없을 때
                                if(wrongsData[i]['example'+j+"Count"] == 0){
                                    $('#wrong_detail_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['example'+j]);

                                }else {
                                    //오답자가 있는경우
                                    $('#wrong_detail_' + wrongsData[i]['number'] + "_" + j).text(wrongsData[i]['example' + j])
                                        .append($('<div>').css({display:"inline",float:"right"}).text(wrongsData[i]['example' + j + "Count"] + "명"));
                                }
                            }
                        }
                    }

                },
                error: function (data) {
                    alert("해당 학생별 오답 문제 가져오기");
                }
            });

        }

        //학생별 오답 가져오기
        function getStudentWrongAnswer(userId,raceId) {

            var reqData ={"userId" : userId , "raceId" : raceId};

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getWrongs')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {
                    /*
                     data = { wrongs: {
                                    0: { number: 1,
                                        id: 1,
                                        question: "苦労してためたお金なのだから、一円（　　）無駄には使いたくない。",
                                        hint:"3",

                                        rightAnswer:1,
                                        example1:"たりとも",
                                        example2:"とはいえ",
                                        example3:"だけさえ",

                                        userCount:1,
                                        rightAnswerCount:0,
                                        wrongCount:1,
                                        example1Count:0,
                                        example2Count:0,
                                        example3Count:1,
                                        }
                                    }
                            }
                    */

                    $('#toggle_wrong_answers').empty();

                    var wrongsData = data['wrongs'];

                    for(var i = 0 ; i < wrongsData.length ; i++ ){

                        for(var j = 0 ; j < 3 ; j++) {
                            $('#details_record').append($('<tr>').attr('id', 'detail_wrong_'+wrongsData[i]['number']+"_"+ j));

                            switch (j) {
                                case 0 :
                                    $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['number']).attr('rowSpan',3));
                                    $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['question']).attr('colSpan',2));

                                    break;
                                case 1 :
                                    $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+0));
                                    $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+1));

                                    break;
                                case 2 :
                                    $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+2));
                                    $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+3));
                                    break;
                            }
                        }

                        for(var j = 0 ; j < 4 ; j++){

                            if (j == 0){
                                $('#detail_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['rightAnswer']).css('background-color','#ffa500');

                            }else{
                                $('#detail_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['example'+j]);

                                if(wrongsData[i]['example'+j+'Count'] == 1){
                                    $('#detail_'+wrongsData[i]['number']+"_"+ j).css('background-color','#e5e6e8');
                                }

                            }
                        }

                    }

                },
                error: function (data) {
                    alert("해당 학생별 오답 문제 가져오기");
                }
            });

        }

        //오답 노트 작성 메서드
        function getStudentWrongWriting(userId,raceId) {

            $('#wrongQuestions').empty();
            $('.modal_wrong_date').empty();
            $('#modal_wrong_raceName_teacher').empty();

            var date = new Date();
            var year = date.getFullYear(); //년도
            var month = date.getMonth()+1; //월
            var day = date.getDate(); //일
            if ((day+"").length < 2) {       // 일이 한자리 수인 경우 앞에 0을 붙여주기 위해
                day = "0" + day;
            }
            var getToday = year+"년 "+month+"월 "+day+"일"; // 오늘 날짜 (2017-02-07

            //가져온 날짜 입력
            $('.modal_wrong_date').text("오답노트 제출한 날짜");

            var reqData = {'raceId' : raceId};

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getStudents')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {
                    /*
                     data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 : {  year:2018,
                                                month:5,
                                                day:11,
                                                date: "2018-05-07 19:53:46",

                                                raceId:1,
                                                listName:"테스트용 리스트1",
                                                userCount:5,
                                                userName:"김똘똘",
                                                userId: 1300000,
                                                teacherName: "이OO교수",

                                                allCount:6,
                                                allRightCount:4,

                                                grammarCount:2,
                                                grammarRightCount:1.4,

                                                vocabularyCount:2,
                                                vocabularyRightCount:1.2,

                                                wordCount:2,
                                                wordRightCount:1.4,

                                                retestState:"not",
                                                wrongState:"not"
                                              }
                                        }
                    */

                    var StudentData;

                    for(var i = 0 ; i < data['races'].length ; i++){
                        if (userId == data['races'][i]['userId']){
                            StudentData = data['races'][i];
                        }
                    }
                    $('#modal_wrong_raceName_teacher').text(StudentData['listName'] +"  /  " +StudentData['userName'] );

                },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }
            });

            var reqData ={"userId" : userId , "raceId" : raceId};

            var data = {
                group: {id: 1, name: "#WDJ", studentCount: 5},
                wrongs: {
                    0: { number: 1,
                        id: 1,
                        question: "苦労してためたお金なのだから、一円（　　）無駄には使いたくない。",

                        rightAnswerNumber:1,
                        choiceNumber:2,

                        example1:"たりとも",
                        example1Number:2,
                        example2:"とはいえ",
                        example2Number:1,
                        example3:"だけさえ",
                        example3Number:3,
                        example4:"ばかりも",
                        example4Number:4,

                        userCount: 5,
                        rightAnswerCount:1,
                        example1Count:1,
                        example2Count:2,
                        example3Count:1,

                    },

                    1: { number: 2,
                        id: 1,
                        question: "この店は洋食と和食の両方が楽しめる（　　）、お得意さんが多い。",

                        rightAnswerNumber:2,
                        choiceNumber:3,

                        example1:"かたがた",
                        example1Number:1,
                        example2:"とあって",
                        example2Number:2,
                        example3:"にあって",
                        example3Number:3,
                        example4:"にしては",
                        example4Number:4,

                        userCount: 5,
                        rightAnswerCount:1,
                        example1Count:1,
                        example2Count:2,
                        example3Count:1,

                    },
                    2: { number: 3,
                        id: 1,
                        question: "姉は市役所に勤める（　　）、ボランティアで日本語を教えています。",

                        rightAnswerNumber:3,
                        choiceNumber:2,

                        example1:"かたがた",
                        example1Number:1,
                        example2:"こととて",
                        example2Number:2,
                        example3:"かたわら",
                        example3Number:3,
                        example4:"うちに",
                        example4Number:4,

                        userCount: 5,
                        rightAnswerCount:1,
                        example1Count:1,
                        example2Count:2,
                        example3Count:1,

                    }
                }
            };

            var wrongsData = data['wrongs'];

            //wrongsData.length == 3
            for(var i = 0 ; i < 3 ; i++ ){

                for(var j = 0 ; j < 4 ; j++) {
                    $('#wrongQuestions').append($('<tr>').attr('id', 'wrong_question_'+wrongsData[i]['number']+"_"+ j));

                    switch (j) {
                        case 0 :
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['number']).attr('rowSpan',3));
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['question']).attr('colSpan',2));

                            break;
                        case 1 :
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrongQue_'+wrongsData[i]['number']+"_"+1));
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrongQue_'+wrongsData[i]['number']+"_"+2));

                            break;
                        case 2 :
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrongQue_'+wrongsData[i]['number']+"_"+3));
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','wrongQue_'+wrongsData[i]['number']+"_"+4));

                            break;
                        case 3 :
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text("풀이"));
                            $('#wrong_question_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id',wrongsData[i]['number']).attr('name',raceId).attr('colSpan',2)
                                .text("오답노트에 작성한 내용"));

                            break;
                    }
                }

                for(var j = 1 ; j <= 4 ; j++){

                    $('#wrongQue_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['example'+j]);

                    switch (j){
                        case wrongsData[i]['rightAnswerNumber']:
                            $('#wrongQue_'+wrongsData[i]['number']+"_"+ j).css('background-color','#ffa500');

                            break;
                        case wrongsData[i]['choiceNumber']:
                            $('#wrongQue_'+wrongsData[i]['number']+"_"+ j).css('background-color','#e5e6e8');

                            break;
                    }
                }
            }

        }

        //레이스 이름 클릭시 학생들 과제 상태 체크
        function checkHomework(raceId){
            // 요구하는 값
            /*            $postData = array(
                            'raceId'    => 1
                    );*/
            var reqData = {'raceId' : raceId};

            $.ajax({
                type: 'POST',

                url: "{{url('/recordBoxController/homeworkCheck')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: reqData,
                success: function (data) {

                    // data = {
                    //     group: {id: 1, name: "3WDJ"},
                    //     students: {
                    //         0: {
                    //             userId: 1300000
                    //             userName: "김똘똘"
                    //
                    //             retestState: "not"
                    //             wrongState: "not"
                    //         }

                    //          1: {
                    //             userId: 1300000
                    //             userName: "김똘똘"
                    //
                    //             retestState: "not"
                    //             wrongState: "not"
                    //         }
                    //      }
                    // }

                    var stdHomework = data['students'];
                    $('#history_homework').empty();

                    for (var i = 0 ; i < stdHomework.length ; i++ ) {
                        $('#history_homework').append($('<tr id="history_homework_tr' + i + '">'));
                    }

                    for (var i = 0; i < stdHomework.length ; i ++) {
                        $('#history_homework_tr' + i).append($('<td>').text(i + 1));
                        $('#history_homework_tr' + i).append($('<td>').text(stdHomework[i]['userName']));

                        switch (stdHomework[i]['retestState']){
                            case "not" :
                                $('#history_homework_tr' + i).append($('<td>').text("PASS"));

                                break;
                            case "order" :
                                $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미응시")));

                                break;
                            case "clear" :
                                $('#history_homework_tr' + i).append($('<td>').attr('class','modal_openStudentRetestGradeCard')
                                    .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_studentRetestGradeCard">')
                                        .attr('id',stdHomework[i]['raceId']).attr('name',stdHomework['userId']).text("응시")));

                                break;
                        }

                        switch (stdHomework[i]['wrongState']){
                            case "not" :
                                $('#history_homework_tr' + i).append($('<td>').text("PASS"));

                                break;
                            case "order" :
                                $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미제출")));

                                break;
                            case "clear" :
                                $('#history_homework_tr' + i).append($('<td>').attr('class','modal_openStudentWrongGradeCard')
                                    .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_studentWrongGradeCard">')
                                        .attr('id',stdHomework[i]['raceId']).attr('name',stdHomework['userId']).text("제출")));

                                break;
                        }

                    }


                },
                error: function (data) {
                    alert("과제 조회 에러2");
                }
            });
        }


        //학생 한명 클릭하면 개인성적 가져오기
        $(document).on('click','.stdList',function () {
            getStudentGrade(this.id);

        });

        //학생 클릭시 해당 학생 개인성적 조회 및 그래프 로드
        function getStudentGrade(userId) {
            // 요구하는 값
//        $postData = array(
//            'userId'    => 1300000
//        );

            var reqData = {'userId' : userId };

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getStudents')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {

                    /*
                     data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 :ty {  year:2018
                                                month:5
                                                day:11

                                                raceId:2
                                                listName:"테스트용 리스트1"
                                                userCount:5
                                                userName:"김똘똘"

                                                allCount:6
                                                allRightCount:4

                                                grammarCount:2
                                                grammarRightAnswerCount:1.4

                                                vocabularyCount:2
                                                vocabularyRightAnswerCount:1.2

                                                wordCount:2
                                                wordRightAnswerCount:1.4

                                                retestState:not
                                                wrongState:not
                                              }
                                        }
                    */

                        var ChartData = makingStudentChartData(data);
                        var raceData = data['races'];
                        makingStudentChart(ChartData);

                        $('#studentGradeList').empty();

                        for( var i = 0 ; i < raceData.length ; i++ ){
                            $('#studentGradeList').append($('<tr>').attr('id','stdGrade_'+i));
                        }

                        for( var i = 0 ; i < raceData.length ; i++ ) {
                            $('#stdGrade_' + i).append($('<td>').text(i+1));
                            $('#stdGrade_' + i).append($('<td>').text(raceData[i]['year']+"년 "+raceData[i]['month']+"월 "+raceData[i]['day']+"일"));
                            $('#stdGrade_' + i).append($('<td>').text(raceData[i]['listName']));
                            $('#stdGrade_' + i).append($('<td>').text(ChartData['total_data'][1][i]['y']));
                            $('#stdGrade_' + i).append($('<td>').text(ChartData['voca_data'][1][i]['y']));
                            $('#stdGrade_' + i).append($('<td>').text(ChartData['grammer_data'][1][i]['y']));
                            $('#stdGrade_' + i).append($('<td>').text(ChartData['word_data'][1][i]['y']));

                            switch (raceData[i]['retestState']){
                                case "not" :
                                    $('#stdGrade_' + i).append($('<td>').text("PASS"));
                                    break;
                                case "order" :
                                    $('#stdGrade_' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미응시")));

                                    break;
                                case "clear" :
                                    $('#stdGrade_' + i).append($('<td>').attr('class','modal_openStudentRetestGradeCard')
                                        .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_studentRetestGradeCard">')
                                            .attr('id',raceData[i]['raceId']).attr('name',userId).text("응시")));

                                    break;
                            }
                            //임시로 yes로 바꿈
                            raceData[i]['wrongState'] = "clear";

                            switch (raceData[i]['wrongState']){
                                case "not" :
                                    $('#stdGrade_' + i).append($('<td>').text("PASS"));

                                    break;
                                case "order" :
                                    $('#stdGrade_' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미제출")));

                                    break;
                                case "clear" :
                                    $('#stdGrade_' + i).append($('<td>').attr('class','modal_openStudentWrongGradeCard')
                                        .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_studentWrongGradeCard">')
                                            .attr('id',raceData[i]['raceId']).attr('name',userId).text("제출")));

                                    break;
                            }

                            $('#stdGrade_'+i).append($('<td>').attr('class','modal_openStudentGradeCard')
                                .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_studentGradeCard">')
                                    .attr('id',raceData[i]['raceId']).attr('name',userId).text("성적표")));
                        }

                    },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }
            });
        }

        function makingChartData(raceData) {

            var raceData = raceData['races'];

            /*raceData = {
                            0: {
                                year: 2018,
                                month: 5,
                                day: 9,

                                raceId: 2,
                                listName: "테스트용 리스트1",
                                userCount: 5,

                                quizCount: 6,
                                rightAnswerCount: 4.2,

                                grammarCount: 2,
                                grammarRightAnswerCount: 1.6,

                                vocabularyCount: 2,
                                vocabularyRightAnswerCount: 1.6,

                                wordCount: 2,
                                wordRightAnswerCount: 1,
                            },

                            1: {
                                year: 2018,
                                month: 5,
                                day: 9,

                                raceId: 2,
                                listName: "테스트용 리스트1",
                                userCount: 5,

                                quizCount: 6,
                                rightAnswerCount: 4.2,

                                grammarCount: 2,
                                grammarRightAnswerCount: 1.6,

                                vocabularyCount: 2,
                                vocabularyRightAnswerCount: 1.6,

                                wordCount: 2,
                                wordRightAnswerCount: 1,
                            }
                        };*/


            var total_data_Points = [];
            var grammer_data_Points = [];
            var vocabulary_Points = [];
            var word_data_Points = [];
            var AllChartData = [];

            for(var i = 0 ; i < raceData.length ; i++){

                //총점 구하기
                var total_grade = ((100 / raceData[i]['quizCount']).toFixed(1) *  raceData[i]['rightAnswerCount']).toFixed(0);

                //문법 총점 구하기
                var grammer_grade = ((33 / raceData[i]['grammarCount']).toFixed(1) *  raceData[i]['grammarRightAnswerCount']).toFixed(0);

                //어휘 총점 구하기
                var vocabulary_grade = ((33 / raceData[i]['vocabularyCount']).toFixed(1) *  raceData[i]['vocabularyRightAnswerCount']).toFixed(0);

                //단어 총점 구하기
                var word_grade = ((33 / raceData[i]['wordCount']).toFixed(1) *  raceData[i]['wordRightAnswerCount']).toFixed(0);

                //차트 데이터 배열 만들기
                total_data_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                                         y : parseInt(total_grade) ,
                                         label : raceData[i]['listName']});

                grammer_data_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                                           y : parseInt(grammer_grade) ,
                                           label : raceData[i]['listName']});

                vocabulary_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                                         y : parseInt(vocabulary_grade) ,
                                         label : raceData[i]['listName']});

                word_data_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                                        y : parseInt(word_grade) ,
                                        label : raceData[i]['listName']});
            }

            //차트 데이터 합치기
            AllChartData = { "total_data" : ["전체 평균 점수" , total_data_Points] ,
                "voca_data" : ["어학 점수", vocabulary_Points] ,
                "grammer_data" : ["독해 점수" , grammer_data_Points] ,
                "word_data" : ["단어 점수" , word_data_Points]
            };



            return AllChartData;
        }

        function makingStudentChartData(data){
            var raceData = data['races'];

            /*
                     data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 : {  year:2018
                                                month:5
                                                day:11
                                                date:DateString

                                                raceId:2
                                                listName:"테스트용 리스트1"
                                                userCount:5
                                                userName:"김똘똘"
                                                userId:1300000

                                                allCount:6
                                                allRightCount:4

                                                grammarCount:2
                                                grammarRightCount:0

                                                vocabularyCount:2
                                                vocabularyRightCount:1

                                                wordCount:2
                                                wordRightCount:1

                                                retestState:not
                                                wrongState:not
                                              }
                                        }
                    */

            var total_data_Points = [];
            var grammer_data_Points = [];
            var vocabulary_Points = [];
            var word_data_Points = [];
            var AllChartData = [];

            for(var i = 0 ; i < raceData.length ; i++){

                //총점 구하기
                var total_grade = ((100 / raceData[i]['allCount']).toFixed(1) *  raceData[i]['allRightCount']).toFixed(0);

                //문법 총점 구하기
                var grammer_grade = ((33 / raceData[i]['grammarCount']).toFixed(1) *  raceData[i]['grammarRightCount']).toFixed(0);

                //어휘 총점 구하기
                var vocabulary_grade = ((33 / raceData[i]['vocabularyCount']).toFixed(1) *  raceData[i]['vocabularyRightCount']).toFixed(0);

                //단어 총점 구하기
                var word_grade = ((33 / raceData[i]['wordCount']).toFixed(1) *  raceData[i]['wordRightCount']).toFixed(0);

                //차트 데이터 배열 만들기
                total_data_Points.push({ x : new Date(raceData[i]['date']),
                    y : parseInt(total_grade) ,
                    label : raceData[i]['listName']});

                grammer_data_Points.push({ x : new Date(raceData[i]['date']),
                    y : parseInt(grammer_grade) ,
                    label : raceData[i]['listName']});

                vocabulary_Points.push({ x : new Date(raceData[i]['date']),
                    y : parseInt(vocabulary_grade) ,
                    label : raceData[i]['listName']});

                word_data_Points.push({ x : new Date(raceData[i]['date']),
                    y : parseInt(word_grade) ,
                    label : raceData[i]['listName']});
            }

            //차트 데이터 합치기
            AllChartData = { "total_data" : ["전체 평균 점수" , total_data_Points] ,
                "voca_data" : ["어학 점수", vocabulary_Points] ,
                "grammer_data" : ["독해 점수" , grammer_data_Points] ,
                "word_data" : ["단어 점수" , word_data_Points]
            };

            return AllChartData;
        }

        //차트 만들 데이터
        function makingChart(data){

            //data = { "total_data" : [ "전체 평균 점수" , { x: new Date(0,0,0) , y: 80 , label: "문제 : 스쿠스쿠"}]}
            //data['total_data'] , data['voca_data'] , data['grammer_data'] , data['word_data']
            //data['total_data'][0]     ==  "전체 평균 점수"
            //data['total_data'][1]     == {x , y , label}

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{},
                axisX:{
                    labelFontSize: 15,
                    valueFormatString: "MMM DD (HH:ss)",
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true
                    }
                },
                axisY: {
                    maximum: 100,
                    crosshair: {
                        enabled: true,
                    }
                },
                toolTip:{
                    shared: true,
                },
                legend:{
                    cursor:"pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "center",
                    itemclick: toogleDataSeries
                },
                data: [{
                    type: "line",
                    showInLegend: true,
                    xValueFormatString: "DD, DD MMM, YYYY, HH, mm ,ss",
                    axisYType: "secondary",
                    // name: "전체 평균 점수",
                    name: data['total_data'][0],

                    markerType: "square",
                    toolTipContent: "{label}" + "<br>" + "<span class='chart_total'>{name}:</span> {y}",
                    color: "#F08080",
                    dataPoints: data['total_data'][1]
                },
                    {
                        type: "line",
                        showInLegend: true,

                        // name: "어학 점수",
                        name: data['voca_data'][0],

                        lineDashType: "dash",
                        toolTipContent: "<span class='chart_vocabulary'>{name}:</span> {y}",
                        dataPoints: data['voca_data'][1]
                    },
                    {
                        type: "line",
                        showInLegend: true,

                        // name: "독해 점수",
                        name: data['grammer_data'][0],

                        lineDashType: "dash",
                        toolTipContent: "<span class='chart_grammer'>{name}:</span> {y}",
                        dataPoints: data['grammer_data'][1]
                    },
                    {
                        type: "line",
                        showInLegend: true,

                        // name: "단어 점수",
                        name: data['word_data'][0],

                        lineDashType: "dash",
                        toolTipContent: "<span class='chart_word'>{name}:</span> {y}",
                        dataPoints: data['word_data'][1]
                    }
                ]
            });
            chart.render();

            function toogleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }

        //학생 개인 차트 만들 데이터
        function makingStudentChart(data){

            //data = { "total_data" : [ "전체 평균 점수" , { x: new Date(0,0,0) , y: 80 , label: "문제 : 스쿠스쿠"}]}
            //data['total_data'] , data['voca_data'] , data['grammer_data'] , data['word_data']
            //data['total_data'][0]     ==  "전체 평균 점수"
            //data['total_data'][1]     == {x , y , label}

            var chart = new CanvasJS.Chart("chartContainer_privacy_student", {
                animationEnabled: true,
                theme: "light2",
                title:{},
                width:1300,
                height:500,
                axisX:{
                    labelFontSize: 15,
                    valueFormatString: "MMM DD (HH:ss)",
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true
                    }
                },
                axisY: {
                    maximum: 100,
                    crosshair: {
                        enabled: true,
                    }
                },
                toolTip:{
                    shared: true,
                },
                legend:{
                    cursor:"pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "center",
                    itemclick: toogleDataSeries
                },
                data: [{
                    type: "line",
                    showInLegend: true,
                    xValueFormatString: "DD, DD MMM, YYYY",

                    // name: "전체 평균 점수",
                    name: data['total_data'][0],

                    markerType: "square",
                    toolTipContent: "{label}" + "<br>" + "<span class='chart_total'>{name}:</span> {y}",
                    color: "#F08080",
                    dataPoints: data['total_data'][1]
                },
                    {
                        type: "line",
                        showInLegend: true,

                        // name: "어학 점수",
                        name: data['voca_data'][0],

                        lineDashType: "dash",
                        toolTipContent: "<span class='chart_vocabulary'>{name}:</span> {y}",
                        dataPoints: data['voca_data'][1]
                    },
                    {
                        type: "line",
                        showInLegend: true,

                        // name: "독해 점수",
                        name: data['grammer_data'][0],

                        lineDashType: "dash",
                        toolTipContent: "<span class='chart_grammer'>{name}:</span> {y}",
                        dataPoints: data['grammer_data'][1]
                    },
                    {
                        type: "line",
                        showInLegend: true,

                        // name: "단어 점수",
                        name: data['word_data'][0],

                        lineDashType: "dash",
                        toolTipContent: "<span class='chart_word'>{name}:</span> {y}",
                        dataPoints: data['word_data'][1]
                    }
                ]
            });
            chart.render();

            function toogleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }

        //재시험 점수 가져오기
        function getRetestData(){

//        $postData = array(
//            'userId'        => 1300000
//            'raceId'        => 1
//            'retestState'   => 1
//        );
            var reqData = {"userId" : 1300000, "retestState" : 1};

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getStudents')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: reqData,
                success: function (data) {

                    /*
                     data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 : {  year:2018
                                                month:5
                                                day:11

                                                raceId:2
                                                listName:"테스트용 리스트1"
                                                userCount:5
                                                userName:"김똘똘"

                                                allCount:6
                                                allRightCount:4

                                                grammarCount:2
                                                grammarRightAnswerCount:1.4

                                                vocabularyCount:2
                                                vocabularyRightAnswerCount:1.2

                                                wordCount:2
                                                wordRightAnswerCount:1.4

                                                retestState:not
                                                wrongState:not
                                              }
                                        }
                    */

                   console.log(data);

                },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }

            })
        }

        //레코드 네비바 클릭 할 때 마다 보여줄 페이지를 보여주기 및 숨기기
        function recordControl(id){

            switch (id){
                case "chart" :
                    $('#group_chart').attr('class','');
                    $('#record_history').attr('class','hidden');
                    $('#record_students').attr('class','hidden');
                    $('#record_homework').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "history" :
                    $('#record_history').attr('class','');
                    $('#group_chart').attr('class','hidden');
                    $('#record_students').attr('class','hidden');
                    $('#record_homework').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "students" :
                    $('#record_students').attr('class','');
                    $('#group_chart').attr('class','hidden');
                    $('#record_history').attr('class','hidden');
                    $('#record_homework').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "homework" :
                    $('#record_homework').attr('class','');
                    $('#group_chart').attr('class','hidden');
                    $('#record_history').attr('class','hidden');
                    $('#record_students').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "feedback" :
                    $('#record_feedback').attr('class','');
                    $('#group_chart').attr('class','hidden');
                    $('#record_students').attr('class','hidden');
                    $('#record_history').attr('class','hidden');
                    $('#record_homework').attr('class','hidden');
                    break;
            }
        }

    </script>

</head>
<body>

{{--메인 네비바 불러오기--}}
<div id="main-navbar" >
    @include('Navigation.main_nav')
</div>

{{--사이드바 불러오기--}}
<aside id="menu-main" class="">
    @include('Recordbox.record_sidebar')
</aside>


{{--첫 화면 레이스 목록--}}
<div id="wrapper" class="">

    {{--레코드 네비바 불러오기--}}
    <div id="main-recordnav" style="margin-bottom: 20px;">
        @include('Recordbox.record_recordnav')
    </div>

    <div id="group_chart">
        @include('Recordbox.record_chart')
    </div>

    <div class="hidden" id="record_history">
        @include('Recordbox.record_history')
    </div>

    <div class="hidden" id="record_students">
        @include('Recordbox.record_studentslist')
    </div>

    <div class="hidden" id="record_feedback">
        @include('Recordbox.record_feedback')
    </div>

</div>



<div class="modal_page">
    {{--Modal : Race Record--}}
    <div class="modal fade" id="modal_RaceGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 1200px">

            <div class="modal-content grade" style="padding: 10px 20px 0 20px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>

                    <div class="modal_date" style="text-align: right;"> </div>

                    <div class="" id="modal_raceName_teacher" style="text-align:center;"></div>

                </div>

                <div class="modal-body" style="text-align: left;margin: 0;">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>
                                학생
                            </th>
                            <th>
                                평균점수
                            </th>
                            <th>
                                어휘
                            </th>
                            <th>
                                문법
                            </th>
                            <th>
                                독해
                            </th>
                            <th>
                                갯수
                            </th>
                        </tr>
                        </thead>
                        <tbody id="grade_list">

                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <div class="modal_total_list" id="modal_total_grade" style="width: 30%;float: right;"> </div>
                </div>
            </div>

            {{--상세 보기--}}
            <div class="modal-content detail" style="margin-top: 10px;padding: 10px 20px 0 20px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="text-align: center;">상세 보기</h3>
                </div>

                <div class="modal-body" style="text-align: left;margin: 0;">

                    <div class="" style="text-align: center;">
                        <input type="checkbox" checked="checked" id="checkbox_0" value="0" onclick="toggle_detailStudent_and_Wrong()">학생
                        <input type="checkbox" checked="checked" id="checkbox_1" value="1" onclick="toggle_detailStudent_and_Wrong()">오답 문제
                    </div>

                    <div id="toggle_only_students">
                        <div class="gradeDetail_student" style="height: 550px;width: 100%;">
                            <div class="modal_list_student" style="width: 100%;margin-top: 10px;">학생</div>

                            <div class="stdAllList_scroll" style="float: left;overflow-y: scroll;margin-left: 60px;height: 500px;border: 1px solid #e5e6e8;">
                                <div id="stdAllList" style="width: 250px;">
                                    <table class="table table-hover table-bordered" style="width: 100%;height: 0;">
                                        <thead>
                                        <tr>
                                            <th width="50px">
                                                번호
                                            </th>
                                            <th>
                                                이름
                                            </th>
                                        </tr>
                                        </thead>

                                        {{--getStudent()로 학생들 불러오기--}}
                                        <tbody id="toggle_student_list">

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div style="margin-top: 50px;margin-left: 50px;margin-right: 50px;float: left;">
                                >
                            </div>

                            <div class="stdAllList_scroll" style="float: left;overflow-y: scroll;margin-left: 60px;height: 500px;border: 1px solid #e5e6e8;">
                                <div id="stdAllList" style="width: 600px;">
                                    <table class="table table-hover table-bordered" style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th width="50px">
                                                번호
                                            </th>
                                            <th colspan="3">
                                                정답
                                            </th>
                                        </tr>
                                        </thead>

                                        {{--getStudent()로 학생들 불러오기--}}
                                        <tbody id="toggle_wrong_answers">

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="toggle_only_wrong_answers" class="" style="width: 100%;clear: left">

                        <div class="modal_list_wrong" style="width: 100%;margin-top: 10px;text-align: left;">오답 문제</div>

                        <table class="table table-hover">
                            <thead>
                            <tr id="race_detail_record">
                                <th style="width: 50px">
                                    번호
                                </th>
                                <th colspan="2">
                                    문제
                                </th>
                                <th style="width: 100px">
                                    오답률
                                </th>
                            </tr>
                            </thead>

                            <tbody id="wrong_detail">

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



    {{--Modal : Student Grade--}}
    <div class="modal fade" id="modal_studentGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 1200px">

            <div class="modal-content grade" style="padding: 10px 20px 0 20px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>

                    <div class="modal_student_date" style="width: 100%;text-align: right;"> </div>

                    <div class="" id="modal_student_raceName_teacher" style="width: 100%;text-align: center;"> </div>

                </div>
                <div class="modal-body" style="text-align: left;margin: 0;">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>
                                학생
                            </th>
                            <th>
                                평균점수
                            </th>
                            <th>
                                어휘
                            </th>
                            <th>
                                문법
                            </th>
                            <th>
                                독해
                            </th>
                            <th>
                                갯수
                            </th>
                        </tr>
                        </thead>
                        <tbody id="studentGradeCard">

                        </tbody>
                    </table>
                </div>

                <input type="hidden" name="hiddenValue" id="hiddenValue" value="" />

                <div class="modal-footer">
                </div>
            </div>

            {{--상세 보기--}}
            <div class="modal-content detail" style="margin-top: 10px;padding: 10px 20px 0 20px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="text-align: center;">상세 보기</h3>
                </div>

                <div class="modal-body" style="text-align: left;margin: 0;">

                    <div class="gradeDetail_quiz" style="width: 100%;clear: left">

                        <table class="table table-hover">
                            <thead>
                            <tr id="race_detail_record">
                                <th style="width: 50px">
                                    번호
                                </th>
                                <th colspan="2">
                                    문제
                                </th>
                            </tr>
                            </thead>

                            <tbody id="details_record">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{--Modal : Student Retest Record--}}
    <div class="modal fade" id="modal_studentRetestGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 1200px">

            <div class="modal-content grade" style="padding: 10px 20px 0 20px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>

                    <div class="modal_student_date" style="width: 100%;text-align: right;"> </div>

                    <div class="student_race_and_teacher" style="width: 100%;">
                        <h5 style="margin: 0;text-align:center">
                            <div class="" id="modal_student_raceName_teacher" style="display: inline;margin-right: 10px;"> </div>

                        </h5>
                    </div>

                </div>
                <div class="modal-body" style="text-align: left;margin: 0;">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>
                                학생
                            </th>
                            <th>
                                평균점수
                            </th>
                            <th>
                                어휘
                            </th>
                            <th>
                                문법
                            </th>
                            <th>
                                독해
                            </th>
                            <th>
                                갯수
                            </th>
                        </tr>
                        </thead>
                        <tbody id="studentGradeCard">

                        </tbody>
                    </table>
                </div>

                <input type="hidden" name="hiddenValue" id="hiddenValue" value="" />

                <div class="modal-footer">
                </div>
            </div>

            {{--상세 보기--}}
            <div class="modal-content detail" style="margin-top: 10px;padding: 10px 20px 0 20px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="text-align: center;">상세 보기</h3>
                </div>

                <div class="modal-body" style="text-align: left;margin: 0;">

                    <div class="gradeDetail_quiz" style="width: 100%;clear: left">

                        <table class="table table-hover">
                            <thead>
                            <tr id="race_detail_record">
                                <th style="width: 50px">
                                    번호
                                </th>
                                <th colspan="2">
                                    문제
                                </th>
                            </tr>
                            </thead>

                            <tbody id="details_record">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{--Modal : 오답 노트 --}}
    <div class="modal fade" id="modal_studentWrongGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 1200px">

            <div class="modal-content detail" style="padding: 10px 20px 0 20px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="text-align: center;">오답 노트</h3>

                    <div class="modal_wrong_date" style="width: 100%;text-align: right;"> </div>

                    <div class="" id="modal_wrong_raceName_teacher" style="text-align: center;width: 100%;"> </div>

                </div>
                <div class="modal-body" style="text-align: left;margin: 0;">
                    <table class="table table-hover">
                        <thead>
                        <tr id="race_detail_record">
                            <th style="width: 50px">
                                번호
                            </th>
                            <th colspan="2">
                                문제
                            </th>
                        </tr>
                        </thead>

                        <tbody id="wrongQuestions">

                        </tbody>
                    </table>

                </div>

                <input type="hidden" name="hiddenValue" id="hiddenValue" value="" />

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="changeCheck()" id="feedback_modal_confirm">확인</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modal_feedback_cancel">취소</button>
                </div>

                <script>
                    function changeCheck(){
                        alert('정상 등록하였습니다.');
                        $('#1check').attr('class','btn btn-primary').text('확인');
                    }
                </script>
            </div>


        </div>
    </div>






</div>


</body>
</html>