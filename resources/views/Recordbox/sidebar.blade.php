<!DOCTYPE HTML>
<html>
<head>
    <script>
        window.onload = function() {

            var dataPoints = [];

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Daily Sales Data"
                },
                axisY: {
                    title: "Units",
                    titleFontSize: 24
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,### Units",
                    dataPoints: dataPoints
                }]
            });

            function addData(data) {
                for (var i = 0; i < data.length; i++) {
                    dataPoints.push({
                        x: new Date(data[i].date),
                        y: data[i].units
                    });
                }
                chart.render();

            }

            $.getJSON("https://canvasjs.com/data/gallery/javascript/daily-sales-data.json", addData);

        }
    </script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>










/*******************************************************************************************************/
<script>

    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{},

            axisY:{
                includeZero: false
            },
            data: [{
                type: "line",
                name: "전체 평균 점수",
                markerType: "square",
                color: "#F08080",
                dataPoints: [
                    { x: new Date(2017, 1, 14), y: 86 , label: "문제 : 스쿠스쿠1"  },
                    { x: new Date(2017, 1, 15), y: 89 , label: "문제 : 스쿠스쿠1" },
                    { x: new Date(2017, 1, 16), y: 93 , label: "문제 : 스쿠스쿠1"  }
                ]
            },
                {
                    type: "line",
                    showInLegend: true,
                    name: "어학 점수",
                    lineDashType: "dash",
                    dataPoints: [
                        { x: new Date(2017, 1, 14), y: 32 , label: "문제 : 스쿠스쿠1" },
                        { x: new Date(2017, 1, 15), y: 30  , label: "문제 : 스쿠스쿠1" },
                        { x: new Date(2017, 1, 16), y: 32 , label: "문제 : 스쿠스쿠1" }
                    ]
                },
                {
                    type: "line",
                    showInLegend: true,
                    name: "문법 점수",
                    lineDashType: "dash",
                    dataPoints: [
                        { x: new Date(2017, 1, 14), y: 28 , label: "문제 : 스쿠스쿠1" },
                        { x: new Date(2017, 1, 15), y: 32 , label: "문제 : 스쿠스쿠1"  },
                        { x: new Date(2017, 1, 16), y: 30 , label: "문제 : 스쿠스쿠1" }
                    ]
                },
                {
                    type: "line",
                    showInLegend: true,
                    name: "독해 점수",
                    lineDashType: "dash",
                    dataPoints: [
                        { x: new Date(2017, 1, 14), y: 31 , label: "문제 : 스쿠스쿠1" },
                        { x: new Date(2017, 1, 15), y: 32 , label: "문제 : 스쿠스쿠1" },
                        { x: new Date(2017, 1, 16), y: 33 , label: "문제 : 스쿠스쿠1"  }
                    ]
                }
            ]
        });
        chart.render();

    }

</script>