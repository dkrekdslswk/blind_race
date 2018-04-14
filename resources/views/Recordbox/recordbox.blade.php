<!DOCTYPE html>

<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard with Off-canvas Sidebar</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">
    <style type="text/css">

        .record_page {
            margin-left: 260px;
            display : inline-block;
        }
        .chart {
            width: 900px;
            height: 500px;
        }
        .container {
            margin-top: 10px;
        }

        .container table {
            width: 900px;
        }

        #curve_chart {
            margin-top: 1em;

        }

    </style>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>

        window.onload = function(){
            var groupID = { groupId : 1 };

            $.ajax({
                type: 'POST',
                url: "{{url('recordBoxController/totalScoreGet')}}",
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: groupID,
                success: function (data) {

                    console.log(data);
                    console.log(data.lastData[0].userName);

                    for(var i = 0; i < data.lastData.length; i++) {
                        var $tbody = $('<tr id=""/>').appendTo('#student_table_tbody');

                        $('<td />').text(data.lastData[i].userName).appendTo($tbody);

                    }

                },
                error: function(request, status, error) {
                    alert("code: "+request.status+"\n"+"message: "+request.responseText+"\n"+"error: "+error);
                }
            });



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
                    legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));


                chart.draw(data, options);

            }
        }



    </script>


</head>
<body>

    <nav>
    @include('Navigation.mainnav')
    </nav>

    <!--aside 자리-->
    <aside style="display:inline-block; vertical-align:top;">
    @include('Recordbox.Side_Bar')
    </aside>

    <!--<div id="app"></div>-->
    <!--<script src="{{asset('js/app.js')}}"></script>  -->

    <div class="record_page">

        <div class="class_page">

            <div id="class_bar" class="ClassBar">
                <button type="button" class="btn btn-primary" style="display: inline;" >2-특강 A반</button>
                <div style="margin-left: 370px;margin-right: 370px;display: inline;"></div>
                <select id="bookSelect" >
                    <blank></blank>
                    <option value="1">레이스</option>
                    <option value="2">골든벨</option>
                </select>
            </div>

            <div id="curve_chart" class="chart"></div>

            <div class="container" >

                <table class="table" id="student_table">
                    <thead>
                        <tr>
                            <th>이름</th>
                            <th>시험점수</th>
                            <th>레이스</th>
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

