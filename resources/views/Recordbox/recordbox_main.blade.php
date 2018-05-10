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

        //처음 화면 로드
        window.onload = function() {

            /*part.1 사이드바*/
            //클래스 불러오기
            getGroups(group_id);

            /*part.2 메인 페이지*/
            //페이지 전부 불러오기
            pageChartLoad(group_id);


            /*test*/
            check();

        };

        //클래스 클릭 할 때 마다 메인 페이지 로드
        $(document).on('click','.groups',function () {

            var reqGroupId = $(this).attr('id');
            var reqGroupName = $(this).attr('name');

            //레코드 네비바 클래스 이름 바꾸기
            $('#nav_group_name').text(reqGroupName);

            //메인 페이지 불러오기
            pageChartLoad(reqGroupId);

        });


        //차트 페이지 로드
        function pageChartLoad(groupId){

            /*part.1 차트화면*/
            //차트 만들기 실행 -> record_chart.blade.php
            makingChart(id,DateType);

        }

        function check() {

            var groupId = {"groupId" : "1"};

            $.ajax({
                type: 'POST',
                url: "{{url('/recordBoxController/getRecordData')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: groupId,
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
                    */

                    /* data.group == data.group */

                    var group_data = data['group'];
                    console.log(group_data);

                    var races_data = data['races'];

                    var total_data_Points = [];
                    var grammer_data_Points = [];
                    var vocabulary_Points = [];
                    var word_data_Points = [];

                    for(var i = 0 ; i < races_data.length ; i++){

                        //총점 구하기
                        var total_grade = ((100 / 6).toFixed(1) *  data['races'][i]['rightAnswerCount']).toFixed(0);

                        //문법 총점 구하기
                        var grammer_grade = ((33 / data['races'][0]['grammarCount']).toFixed(1) *  data['races'][i]['grammarRightAnswerCount']).toFixed(0);

                        //어휘 총점 구하기
                        var vocabulary_grade = ((33 / data['races'][0]['vocabularyCount']).toFixed(1) *  data['races'][i]['vocabularyRightAnswerCount']).toFixed(0);

                        //단어 총점 구하기
                        var word_grade = ((33 / data['races'][0]['wordCount']).toFixed(1) *  data['races'][i]['wordRightAnswerCount']).toFixed(0);

                        //차트 데이터 배열 만들기
                        total_data_Points.push({ x : new Date(races_data[i]['year'],races_data[i]['month'],races_data[i]['day']),
                                                 y : total_grade ,
                                                 label : races_data[i]['listName']});

                        grammer_data_Points.push({  x : new Date(races_data[i]['year'],races_data[i]['month'],races_data[i]['day']),
                                                    y : grammer_grade ,
                                                    label : races_data[i]['listName']});

                        vocabulary_Points.push({ x : new Date(races_data[i]['year'],races_data[i]['month'],races_data[i]['day']),
                                                 y : vocabulary_grade ,
                                                 label : races_data[i]['listName']});

                        word_data_Points.push({ x : new Date(races_data[i]['year'],races_data[i]['month'],races_data[i]['day']),
                                                y : word_grade ,
                                                label : races_data[i]['listName']});
                    }

                    console.log(total_data_Points);
                    console.log(grammer_data_Points);
                    console.log(vocabulary_Points);
                    console.log(word_data_Points);

                },
                error: function (data) {
                    alert("에러");
                }
            });
        }



        //클래스 가져오기
        function getGroups(groupId) {

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
                    GroupData = data;

                    for( var i = 0 ; i < GroupData['groups'].length ; i++ ){

                        $('#group_names').append($('<a href="#">')
                            .append($('<div class="groups" name="'+GroupData['groups'][i].groupName+'" id="'+ GroupData['groups'][i].groupId +'">')
                            .text(GroupData['groups'][i].groupName)));

                    }

                    $('#nav_group_name').text(GroupData['groups'][0].groupName);
                },
                error: function (data) {
                    alert("에러");
                }
            });

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