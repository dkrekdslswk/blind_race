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
    <script src="js/moment.min.js"></script>
    <script src="js/combodate.js"></script>

    <script type="text/javascript">


        //학생 개인 차트 만들 데이터
        function makingStudentChart(data,axisXType){

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