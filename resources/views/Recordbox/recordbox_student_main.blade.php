<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
            transition: all 0.4s ease 0s;
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

        #group_chart {
            margin-left: 20px;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script type="text/javascript">

        var user_id = 1300000;
        var group_id = 1;

        window.onload = function () {
            getGroups_and_loadChart(user_id,group_id);
        };

        $(document).on('click','.modal_openStudentGradeCard button',function () {
            var raceId = $(this).attr('id');
            var userId = $(this).attr('name');

            loadStudentGradeCard(user_id,raceId);
        });

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

            getChartData_and_loadChart(user_id,startDate,defaultEndDate);
        }

        function orderChart(){
            var startDate = document.querySelector('input[id="startDate"]').value;
            var endDate = document.querySelector('input[id="endDate"]').value;

            getChartData_and_loadChart(user_id,startDate,endDate);
        }

        //날짜를 가져와서 조회 및 차트 그리기
        function getChartData_and_loadChart(userId,startDate,endDate){

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

        function getGroups_and_loadChart(userId,groupId) {

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

                },
                error: function (data) {
                    alert("그룹겟 에러");
                }
            });



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

                    console.log(data);
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

                        if (raceData[i]['retestState'] == 'not') {
                            $('#stdGrade_' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미응시")));
                        } else {
                            $('#stdGrade_' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-primary').text("응시")));
                        }

                        if (raceData[i]['wrongState'] == 'not') {
                            $('#stdGrade_' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미응시")));
                        } else {
                            $('#stdGrade_' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-primary').text("응시")));
                        }
                        $('#stdGrade_'+i).append($('<td>').attr('class','modal_openStudentGradeCard')
                            .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_studentGradeCard">')
                                .attr('id',raceData[i]['raceId']).attr('name',userId)
                                .text("성적표")));
                    }

                },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }
            });

        }

        //학생 개인 차트 만들 데이터
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

        //학생 개인 차트 만들기
        function makingStudentChart(data){

            //data = { "total_data" : [ "전체 평균 점수" , { x: new Date(0,0,0) , y: 80 , label: "문제 : 스쿠스쿠"}]}
            //data['total_data'] , data['voca_data'] , data['grammer_data'] , data['word_data']
            //data['total_data'][0]     ==  "전체 평균 점수"
            //data['total_data'][1]     == {x , y , label}

            var chart = new CanvasJS.Chart("chartContainer_privacy_student", {
                animationEnabled: true,
                theme: "light2",
                title:{},
                width:1000,
                height:450,
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

                    getStudentWrongAnswer(userId,raceId);

                },
                error: function (data) {
                    alert("학생별 최근 레이스 값 불러오기 에러");
                }
            });
        }

        function getStudentWrongAnswer(userId,raceId) {

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
            $('#details_record').empty();

            var wrongsData = data['wrongs'];

            //wrongsData.length == 3
            for(var i = 0 ; i < 3 ; i++ ){

                for(var j = 0 ; j < 3 ; j++) {
                    $('#details_record').append($('<tr>').attr('id', 'detail_wrong_'+wrongsData[i]['number']+"_"+ j));

                    switch (j) {
                        case 0 :
                            $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['number']).attr('rowSpan',3));
                            $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').text(wrongsData[i]['question']).attr('colSpan',2));

                            break;
                        case 1 :
                            $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+1));
                            $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+2));

                            break;
                        case 2 :
                            $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+3));
                            $('#detail_wrong_'+wrongsData[i]['number']+"_"+ j).append($('<td>').attr('id','detail_'+wrongsData[i]['number']+"_"+4));
                            break;

                    }
                }

                for(var j = 1 ; j <= 4 ; j++){

                    $('#detail_'+wrongsData[i]['number']+"_"+ j).text(wrongsData[i]['example'+j]);

                    switch (j){
                        case wrongsData[i]['rightAnswerNumber']:
                            $('#detail_'+wrongsData[i]['number']+"_"+ j).css('background-color','#ffa500');

                            break;
                        case wrongsData[i]['choiceNumber']:
                            $('#detail_'+wrongsData[i]['number']+"_"+ j).css('background-color','#e5e6e8');

                            break;
                    }
                }

            }

        }

        function recordControl(id){
            switch (id){
                case "nav_group_name" :
                    $('#record_history').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "history" :
                    $('#record_history').attr('class','');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "feedback" :
                    $('#record_feedback').attr('class','');
                    $('#record_homework').attr('class','hidden');
                    $('#record_history').attr('class','hidden');

                    $('#feedbackCheck').attr('class','hidden');
                    $('#feedbackCheckIcon').attr('class','hidden');
                    break;
            }
        }

        $(document).on('click','#groupA',function () {
            $('#nav_group_name').text("특강 A반");
            $('#wrapper').show();
            $('#group_chart').attr('class','');
            $('#record_history').attr('class','hidden');
        });

        $(document).on('click','#groupB',function () {
            $('#nav_group_name').text("특강 B반");
            $('#wrapper').hide();
        });

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
<div id="wrapper" class="" style="min-height: 1024px;">

    {{--메인 네비바 불러오기--}}
    <div id="main-recordnav" style="margin-bottom: 20px;">
        @include('Recordbox.recordbox_student_recordnav')
    </div>

    <div class="" id="record_history">
        @include('Recordbox.recordbox_student_history')
    </div>

    <div class="hidden" id="record_feedback">
        @include('Recordbox.record_feedback')
    </div>

</div>

</body>
</html>