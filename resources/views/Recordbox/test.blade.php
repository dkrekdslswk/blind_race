<script>
    //예제 그래프 출력
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', '평균점수', '어휘' , '독해' , '문법'],
            ['04월/28일',  90,      20,       35,        40],
            ['04월/27일',  87,      55,       10,        33],
            ['04월/26일',  95,       25,      30,        30],
            ['04월/25일',  75,      30,       20,        10]
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