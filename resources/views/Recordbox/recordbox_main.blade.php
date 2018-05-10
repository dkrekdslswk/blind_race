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

        var group_id = 1;
        var chartData = "";

        //처음 화면 로드
        window.onload = function() {

            /*part.1 사이드바*/
            //클래스 불러오기 and 차트 로드하기
            getGroups_and_loadChart(group_id);

        };

        //클래스 클릭 할 때 마다 메인 페이지(차트) 로드
        $(document).on('click','.groups',function () {

            var reqGroupId = $(this).attr('id');
            var reqGroupName = $(this).attr('name');
            var dateType = selectedDateType();

            //레코드 네비바 클래스 이름 바꾸기
            $('#nav_group_name').text(reqGroupName);

            reqChartData_and_makingChart(reqGroupId , dateType);

        });

        //날짜 타입 라디오 버튼 누를때 마다 차트에 반영
        function changeDateType(){
            var dateType = selectedDateType();

            makingChart(chartData,dateType);
        }

        //조회를 누르면 날짜를 가져와서 조회
        function changeDateTypeToChart(){
            var startDate = document.querySelector('input[id="startDate"]');
            var endDate = document.querySelector('input[id="endDate"]');
            var dateType = selectedDateType();

            var requestData = {"groupId" : group_id , "startDate" : startDate , "endDate" : endDate};

        }

        //최근기록 페이지 로드
        function pageHistoryLoad(groupId){

            /*part.2 최근기록 화면*/
            //차트 만들기 실행 -> record_chart.blade.php

        }

        //학생관리 페이지 로드
        function pageStudentListLoad(groupId){

            /*part.3 학생관리 화면*/
            //차트 만들기 실행 -> record_chart.blade.php

        }

        //과제관리 페이지 로드
        function pageHomeworkLoad(groupId){

            /*part.4 과제관리 화면*/
            //차트 만들기 실행 -> record_chart.blade.php

        }

        //피드백 페이지 로드
        function pageFeedbackLoad(groupId){

            /*part.5 피드백 화면*/
            //차트 만들기 실행 -> record_chart.blade.php

        }

        //클래스 가져오기
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
                    $('#nav_group_name').text(firstGroup.text());

                    //차트 날짜 타입 가져오기
                    var dateType = selectedDateType();

                    //가장 상단에 있는 클래스 ID값으로 차트 만들기
                    reqChartData_and_makingChart(firstGroup.attr('id') , dateType);

                },
                error: function (data) {
                    alert("에러");
                }
            });

        }

        //ajax로 그룹에 대한 차트 정보 가져와서 차트를 만듬
        //request : 그룹아이디(groupId) , X축 차트(날짜) 데이터 타입 (axisXType)
        function reqChartData_and_makingChart(groupId,axisXType) {

            var group_Id = {"groupId" : groupId };
            /*var group_Id = {"groupId" : groupId , "startDate" : "2018-05-01" , "endDate" : "2018-05-08"};*/

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getRecordData')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: group_Id,
                success: function (data) {

                    /*
                    * data = { group : {id : 1 , name : "3WDJ"} ,
                               races : { 0 : {  year:2018
                                                month:5
                                                day:9

                                                raceId:2
                                                listName:"테스트용 리스트1"
                                                userCount:5

                                                quizCount:6
                                                rightAnswerCount:4.2

                                                grammarCount:2
                                                grammarRightAnswerCount:1.6

                                                vocabularyCount:2
                                                vocabularyRightAnswerCount:1.6

                                                wordCount:2
                                                wordRightAnswerCount:1
                                              }
                                        }
                    */

                    /* data.group == data.group */

                    var group_data = data['group'];
                    var races_data = data['races'];

                    var total_data_Points = [];
                    var grammer_data_Points = [];
                    var vocabulary_Points = [];
                    var word_data_Points = [];

                    for(var i = 0 ; i < races_data.length ; i++){

                        //총점 구하기
                        var total_grade = ((100 / data['races'][i]['quizCount']).toFixed(1) *  data['races'][i]['rightAnswerCount']).toFixed(0);

                        //문법 총점 구하기
                        var grammer_grade = ((33 / data['races'][i]['grammarCount']).toFixed(1) *  data['races'][i]['grammarRightAnswerCount']).toFixed(0);

                        //어휘 총점 구하기
                        var vocabulary_grade = ((33 / data['races'][i]['vocabularyCount']).toFixed(1) *  data['races'][i]['vocabularyRightAnswerCount']).toFixed(0);

                        //단어 총점 구하기
                        var word_grade = ((33 / data['races'][i]['wordCount']).toFixed(1) *  data['races'][i]['wordRightAnswerCount']).toFixed(0);

                        //차트 데이터 배열 만들기
                        total_data_Points.push({ x : new Date(2018,5,9),
                                                 y : parseInt(total_grade) ,
                                                 label : races_data[i]['listName']});

                        grammer_data_Points.push({  x : new Date(races_data[i]['year'],races_data[i]['month'],races_data[i]['day']),
                                                    y : parseInt(grammer_grade) ,
                                                    label : races_data[i]['listName']});

                        vocabulary_Points.push({ x : new Date(races_data[i]['year'],races_data[i]['month'],races_data[i]['day']),
                                                 y : parseInt(vocabulary_grade) ,
                                                 label : races_data[i]['listName']});

                        word_data_Points.push({ x : new Date(races_data[i]['year'],races_data[i]['month'],races_data[i]['day']),
                                                y : parseInt(word_grade) ,
                                                label : races_data[i]['listName']});
                    }

                    //차트 데이터 합치기
                    var AllChartData = { "total_data" : ["전체 평균 점수" , total_data_Points] ,
                                        "voca_data" : ["어학 점수", vocabulary_Points] ,
                                        "grammer_data" : ["독해 점수" , grammer_data_Points] ,
                                        "word_data" : ["단어 점수" , word_data_Points]
                                    };

                    //차트 생성
                    makingChart(AllChartData,axisXType);

                    //차트 데이터 변수에 데이터 넣기
                    chartData = AllChartData;

                },
                error: function (data) {
                    alert("에러");
                }
            });
        }

        //차트 만들 데이터
        function makingChart(data,axisXType){

            //data = { "total_data" : [ "전체 평균 점수" , { x: new Date(0,0,0) , y: 80 , label: "문제 : 스쿠스쿠"}]}
            //data['total_data'] , data['voca_data'] , data['grammer_data'] , data['word_data']
            //data['total_data'][0]     ==  "전체 평균 점수"
            //data['total_data'][1]     == {x , y , label}


            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                width: 1000,
                height: 500,
                title:{},
                axisX:{
                    labelFontSize: 15,
                    valueFormatString: axisXType,
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

        function selectedDateType(){
            var selectedradio = $("input[type=radio][name=optradio]:checked").val();
            var date_Type = "";

            switch (selectedradio) {
                case "1":
                    date_Type = "DD";
                    break;

                case "2":
                    date_Type = "DD MMM";
                    break;

                case "3":
                    date_Type = "YYYY";
                    break;
            }

            return date_Type;
        }

        //레코드 네비바 클릭 할 때 마다 보여줄 페이지를 보여주기 및 숨기기
        function recordControl(id){
            switch (id){
                case "nav_group_name" :
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

    <div class="hidden" id="record_homework">
        @include('Recordbox.record_homework')
    </div>

    <div class="hidden" id="record_feedback">
        @include('Recordbox.record_feedback')
    </div>

</div>

</body>
</html>