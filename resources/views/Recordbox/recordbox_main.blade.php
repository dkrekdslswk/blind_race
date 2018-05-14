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
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <script type="text/javascript">

        var chartData = "";
        var group_id = 1;
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
            pageHistoryLoad();
            pageStudentListLoad();

            checkHomework2(1);
        };

        //메인 페이지 로드
        function pageMainLoad(){

            /*part.1 사이드바*/
            //클래스 불러오기 and 차트 로드하기 -> record_chart.blade.php
            getGroups_and_loadChart(group_id);

        }

        //최근기록 페이지 로드
        function pageHistoryLoad(){

            /*part.2 최근기록 화면*/
            //최근 목록 불러오기


        }

        //학생관리 페이지 로드
        function pageStudentListLoad(){

            /*part.3 학생관리 화면*/

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
                    $('#toggle_student_list').empty();

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
                        $('#toggle_student_list').append($('<tr id="toggle_student_list'+i+'">'));

                        for(var j = 0 ; j < 1 ; j++ ) {

                            $('#student_list_' + i).append($('<td>').text(i+1));
                            $('#student_list_' + i).append($('<td>')
                                                    .append($('<a href="#">')
                                                        .text(student[i]['name']))
                                                    .attr('id',student[i]['id'])
                                                    .attr('name',student[i]['name'])
                                                    .attr('class','stdList'));

                            $('#toggle_student_list' + i).append($('<td>').text(i+1));
                            $('#toggle_student_list' + i).append($('<td>')
                                                    .append($('<a href="#" onclick="getWrongAnswer('+student[i]['id']+')">')
                                                        .text(student[i]['name']))
                                                    .attr('id',student[i]['id'])
                                                    .attr('name',student[i]['name'])
                                                    .attr('class','toggle_stdList'));
                        }
                    }


                },
                error: function (data) {
                    alert("그룹에 속한 학생 에러");
                }
            });

        }

        function toggle_detailStudent_and_Wrong(id) {
           switch (id){
               case "0" :

                   $('#toggle_only_students').attr('class','');
                   $('#toggle_only_wrong_answers').attr('class','hidden');
                   break;

               case "1" :
                   $('#toggle_only_students').attr('class','hidden');
                   $('#toggle_only_wrong_answers').attr('class','');

                   break;
           }
        };

        function getWrongAnswer(id) {
            var data = {
                group: {id: 1, name: "#WDJ", studentCount: 5},
                wrong: {
                    0: {0: 3, 1: "たりとも" , 2 : "ばかりも"},
                    1: {1: 13, 1: "とあって" , 2 : "にあって"},
                    2: {2: 17, 1: "かたわら" , 2 : "うちに"},
                },
            };

            for(var i = 0 ; i < 3 ; i++ ){
                $('#toggle_wrong_answers').append($('<tr>').attr('id','toggle_wrong_'+i));

                for(var j = 0 ; j < 3 ; j++){

                    if(j == 0){
                        $('#toggle_wrong_'+i).append($('<td>').text(i+1));
                    }else{
                    $('#toggle_wrong_'+i).append($('<td>').text(data['wrong'][i][j]));
                    }
                }
            }

        }

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

                    for( var i = 0 ; i < data['races'].length ; i++ ){
                        $('#history_list').append($('<tr>').attr('id','history_list_tr'+i));
                    }

                    for( var i = 0 ; i < data['races'].length ; i++ ){
                        $('#history_list_tr'+i).append($('<td>').text(i+1));
                        $('#history_list_tr'+i).append($('<td>').append($('<a href="#" onclick="checkHomework()">').text(data['races'][i]['listName'])));

                        $('#history_list_tr'+i).append($('<td>').text(data['races'][i]['date']));
                        $('#history_list_tr'+i).append($('<td>').text(data['races'][i]['retestClearCount']+"/"+data['races'][i]['retestCount']));

                        $('#history_list_tr'+i).append($('<td>').text(data['races'][i]['wrongClearCount']+"/"+data['races'][i]['wrongCount']));

                        $('#history_list_tr'+i).append($('<td>').append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">').text("성적표")));

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

        function loadGradeCard(value){

            //value = {userId : 1300000}
            //value = {raceId : 1}

            var reqData = value;

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

                    var ChartData = makingStudentChartData(data);
                    makingStudentChart(ChartData);

                    $('#studentGradeList').empty();
                    for( var i = 0 ; i < data['races'].length ; i++ ){
                        $('#studentGradeList').append($('<tr>').attr('id','stdGrade_'+i));
                    }

                    for( var i = 0 ; i < data['races'].length ; i++ ) {
                        $('#stdGrade_' + i).append($('<td>').text(i+1));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['year']+"년 "+data['races'][i]['month']+"월 "+data['races'][i]['day']+"일"));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['listName']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['total_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['voca_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['grammer_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['word_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['retestState']));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['wrongState']));
                        $('#stdGrade_' + i).append($('<td>').append($('<a href="#" class="toggle_openStudentGradeCard" data-toggle="modal" data-target="#modal_studentGradeCard">').attr('id',data['races'][i]['raceId']).text("성적표")));
                    }

                },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }
            });


        }

        function checkHomework2(raceId){
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

                    console.log(data);

                    // data = {
                    //     group: {id: 1, name: "3WDJ"},
                    //     races: {
                    //         0: {
                    //             userId: 1300000
                    //             userName: 김똘똘
                    //
                    //             retestState: "no"
                    //             wrongState: "no"
                    //         }
                    //     }
                    // }

                },
                error: function (data) {
                    alert("과제 조회 에러2");
                }
            });
        }

        function checkHomework(raceId){
            // 요구하는 값
/*            $postData = array(
                'raceId'    => 1
        );*/
            var reqData = {'raceId' : raceId};

            var data = {
                "group": {id: 1, name: "3WDJ"},
                "races": {
                    0 : {
                        "userId": 1300000,
                        "userName": "최천재",
                        "retestState": "yes",
                        "wrongState": "yes",
                    },
                    1 : {
                        "userId": 1300000,
                        "userName": "안예민",
                        "retestState": "no",
                        "wrongState": "no",
                    },
                    2 : {
                        "userId": 1300000,
                        "userName": "심사쵸",
                        "retestState": "no",
                        "wrongState": "no",
                    },
                    3 : {
                        "userId": 1300000,
                        "userName": "사라다",
                        "retestState": "no",
                        "wrongState": "no",
                    }
                }
            };

            $('#history_homework').empty();

            //data['races'].length
            for (var i = 0 ; i < 4 ; i++ ) {
                $('#history_homework').append($('<tr id="history_homework_tr' + i + '">'));
            }

            //data['races'][i].length
            for (var i = 0; i < 4 ; i ++) {
                $('#history_homework_tr' + i).append($('<td>').text(i + 1));
                $('#history_homework_tr' + i).append($('<td>').text(data['races'][i]['userName']));

                if (data['races'][i]['retestState'] == 'no') {
                    $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미응시")));
                } else {
                    $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-primary').text("응시")));
                }

                if (data['races'][i]['wrongState'] == 'no') {
                    $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미응시")));
                } else {
                    $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-primary').text("응시")));
                }
            }


        }

        //학생 한명 클릭하면 개인성적 가져오기
        $(document).on('click','.stdList',function () {
            getStudentGrade(this.id);

        });


        //학생 상세정보에서 성적표 클릭시 성적표 로드
        $(document).on('click','.toggle_openStudentGradeCard',function () {
            //$('.modal-body #hiddenValue').val();
            var userId = $(this).attr('id');
            var userName = $(this).attr('name');

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

                    var ChartData = makingStudentChartData(data);
                    makingStudentChart(ChartData);

                    $('#studentGradeList').empty();
                    for( var i = 0 ; i < data['races'].length ; i++ ){
                        $('#studentGradeList').append($('<tr>').attr('id','stdGrade_'+i));
                    }

                    for( var i = 0 ; i < data['races'].length ; i++ ) {
                        $('#stdGrade_' + i).append($('<td>').text(i+1));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['year']+"년 "+data['races'][i]['month']+"월 "+data['races'][i]['day']+"일"));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['listName']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['total_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['voca_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['grammer_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(ChartData['word_data'][1][0]['y']));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['retestState']));
                        $('#stdGrade_' + i).append($('<td>').text(data['races'][i]['wrongState']));
                        $('#stdGrade_' + i).append($('<td>').append($('<a href="#" class="toggle_openStudentGradeCard" data-toggle="modal" data-target="#modal_studentGradeCard">')
                                                            .attr('id',data['races'][i]['raceId']).text("성적표")));
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


            console.log(AllChartData);

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
                    horizontalAlign: "left",
                    dockInsidePlotArea: true,
                    itemclick: toogleDataSeries
                },
                data: [{
                    type: "line",
                    showInLegend: true,
                    xValueFormatString: "DD, DD MMM, YYYY, HH, mm ,ss",

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
                    valueFormatString: "YYYY MMM DD",
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
                    horizontalAlign: "left",
                    dockInsidePlotArea: true,
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

</body>
</html>