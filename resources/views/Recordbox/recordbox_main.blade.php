<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

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
            margin: 0;
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
            position: absolute;
            /*     min-height: 1000px; */
            top: 0px;
            transition: all 0.4s ease 0s;
            background-color: #ffffff;
            border-left: 1px solid #e1e2e3;
            border-right: 1px solid #e1e2e3;
            border-bottom: 1px solid #e1e2e3;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        //예제 그래프 출력
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses'],
                ['2004',  1000,      400],
                ['2005',  1170,      460],
                ['2006',  660,       1120],
                ['2007',  1030,      540]
            ]);

            var options = {
                title: 'Company Performance',
                curveType: 'function',
                width: 650,
                height: 300,
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));

            chart.draw(data, options);
        }


        /*Ajax로 받은 값을 그래프에 적용*/
        var groupID = { groupId : 1 };

        window.onload = function(){

            $.ajax({
                type: 'POST',
                url: "{{url('recordBoxController/totalScoreGet')}}",
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: groupID,
                success: function (recordData) {

                    console.log(recordData);

                    //그래프 출력
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Date');
                        data.addColumn('number', '현재반 평균 점수');
                        data.addColumn('number', '전체반 평균 점수');

                        for (var i = recordData.raceData.length - 1 ; i >= 0 ; i--){
                            var race_DateTimeSplit = recordData.raceData[i].createDate.split(' ');
                            var race_DateSplit = race_DateTimeSplit[0].split('-');
                            var race_TimeSplit = race_DateTimeSplit[1].split(':');

                            data.addRows([[race_DateSplit[1]+"월 "+race_DateSplit[2]+"일 "+race_TimeSplit[0]+":"+race_TimeSplit[1]+":"+race_TimeSplit[2],
                                recordData.raceData[i].avgScore ,
                                80]
                            ]);
                        }

                        var options = {
                            title: '특강 A반',
                            curveType: 'function',
                            width: 1300,
                            height: 400,
                            chartArea:{left:0,top:0,width:"50%",height:0},
                            legend: {position: 'bottom'},
                            vAxis: {
                                viewWindowMode:'explicit',
                                viewWindow: {
                                    max:100,
                                    min:0
                                }
                            }
                        };


                        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                        chart.draw(data, options);
                    }
                },
                error: function(request, status, error) {
                    alert("code: "+request.status+"\n"+"message: "+request.responseText+"\n"+"error: "+error);
                }
            });

        };

    </script>

</head>
<body>

<div class="main-body">

    {{--메인 네비바 불러오기--}}
    <div id="main-navbar">
        @include('Navigation.main_nav')
    </div>

    {{--첫 화면 레이스 목록--}}
    <div id="wrapper" class="" style="min-height: 1024px;">

        {{--레이스 목록 불러오기--}}
        <div id="myrace">
            @include('Recordbox.test_record')
        </div>

        {{--나의그룹 목록 불러오기--}}
        <div id="mygroup" class="hidden">
            @include('Recordbox.test_record2')
        </div>

    </div>
</div>

</body>
</html>