<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Record Box</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="js/bootstrap.min.js" rel="stylesheet">
</head>

<style type="text/css">

    body {
        background-color: #f5f8fa;
    }

    .record_page {
        margin-left: 300px;
        margin-top: 20px;
        display : inline-block;
    }

    .chart {
        margin-top: 1em;
        width: 900px;
        height: 500px;
    }

    .container {
        margin-top: 10px;
    }

    .container table , .container table thead tr th{
        width: 900px;
        text-align: center;
    }

    .container table thead{
        background-color: #d9edf7;

    }

</style>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var groupID = { groupId : 1 };

    window.onload = function(){

        $.ajax({
            type: 'POST',
            url: "{{url('recordBoxController/totalScoreGet')}}",
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: groupID,
            success: function (recordData) {

                for(var i = 0; i < recordData.lastData.length; i++) {
                    var $tbody = $('<tr id/>').appendTo('#student_table_tbody');
                    var score  = recordData.lastData[i].quizCount / recordData.lastData[i].rightCount;

                    $('<td />').text(recordData.lastData[i].userName).appendTo($tbody);
                    $('<td />').text(score.toFixed(1) + "점").appendTo($tbody);
                    $('<td />').text(recordData.lastData[i].rightCount + ' / ' + recordData.lastData[i].quizCount).appendTo($tbody);
                    $('<td />').append($('<a href="#">').text('미제출')).appendTo($tbody);
                    $('<td />').text('').appendTo($tbody);
                }

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

<body>
    <nav>
        @include('Navigation.main_nav')
    </nav>

    <aside style="display:inline-block; vertical-align:top;">
        @include('Recordbox.sidebar')
    </aside>

    <div class="record_page">

        <div class="class_page">

            <div id="class_bar" class="ClassBar">
                <button type="button" class="btn btn-primary" style="display: inline;" >그룹 선택</button>
                <select id="bookSelect" >
                    <blank></blank>
                    <option value="1">특강 A반</option>
                    <option value="2">특강 B반</option>
                    <option value="3">특강 C반</option>
                </select>
                {{--<div style="margin-left: 370px;margin-right: 370px;display: inline;"></div>--}}
                <button type="button" class="btn btn-primary" style="display: inline;" >문제 유형</button>
                <select id="bookSelect" >
                    <blank></blank>
                    <option value="1">레이스</option>
                    <option value="2">골든벨</option>
                </select>
            </div>

            <div id="curve_chart" class="chart"></div>

            <div class="container" >

                <table class="table">
                    <thead>
                        <tr style="text-align: center">
                            <th>이름</th>
                            <th>시험점수</th>
                            <th>레이스</th>
                            <th>오답 노트</th>
                            <th>재시험</th>
                        </tr>
                    </thead>
                    <tbody id="student_table_tbody">

                    </tbody>
                </table>

            </div>

        </div>

    </div>


</body>

</html>

