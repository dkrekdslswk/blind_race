<!DOCTYPE HTML>
<html>
<head>
    <style>

    </style>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                width: 1000,
                height: 700,
                title:{},
                axisX:{
                    labelFontSize: 15,
                    valueFormatString: "DD MMM",
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true
                    }
                }
                ,
                axisY: {
                    crosshair: {
                        enabled: true
                    }
                },
                toolTip:{
                    shared:true
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
                    name: "전체 점수",
                    markerType: "square",
                    xValueFormatString: "DD, MMM, DD MMM, YYYY",
                    color: "#F08080",
                    toolTipContent: "{name}",
                    dataPoints: [
                        { x: new Date(2017, 0, 3), y: 65, name: "문제 : 스쿠스쿠" },
                        { x: new Date(2017, 0, 4), y: 70 },
                        { x: new Date(2017, 0, 5), y: 71 },
                        { x: new Date(2017, 0, 6), y: 65 },
                        { x: new Date(2017, 0, 7), y: 73 },
                        { x: new Date(2017, 0, 8), y: 96 },
                        { x: new Date(2017, 0, 9), y: 84 },
                        { x: new Date(2017, 0, 10), y: 85 },
                        { x: new Date(2017, 0, 11), y: 86 },
                        { x: new Date(2017, 0, 12), y: 94 },
                        { x: new Date(2017, 0, 13), y: 97 },
                        { x: new Date(2017, 0, 14), y: 86 },
                        { x: new Date(2017, 0, 15), y: 89 },
                        { x: new Date(2017, 0, 16), y: 93 }
                    ]
                },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "어학 점수",
                        lineDashType: "dash",
                        dataPoints: [
                            { x: new Date(2017, 0, 3), y: 51 },
                            { x: new Date(2017, 0, 4), y: 56 },
                            { x: new Date(2017, 0, 5), y: 54 },
                            { x: new Date(2017, 0, 6), y: 55 },
                            { x: new Date(2017, 0, 7), y: 54 },
                            { x: new Date(2017, 0, 8), y: 69 },
                            { x: new Date(2017, 0, 9), y: 65 },
                            { x: new Date(2017, 0, 10), y: 66 },
                            { x: new Date(2017, 0, 11), y: 63 },
                            { x: new Date(2017, 0, 12), y: 67 },
                            { x: new Date(2017, 0, 13), y: 66 },
                            { x: new Date(2017, 0, 14), y: 56 },
                            { x: new Date(2017, 0, 15), y: 64 },
                            { x: new Date(2017, 0, 16), y: 57 }
                        ]
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "문법 점수",
                        lineDashType: "dash",
                        dataPoints: [
                            { x: new Date(2017, 0, 3), y: 24 },
                            { x: new Date(2017, 0, 4), y: 20 },
                            { x: new Date(2017, 0, 5), y: 28 },
                            { x: new Date(2017, 0, 6), y: 35 },
                            { x: new Date(2017, 0, 7), y: 24 },
                            { x: new Date(2017, 0, 8), y: 25 },
                            { x: new Date(2017, 0, 9), y: 35 },
                            { x: new Date(2017, 0, 10), y: 45 },
                            { x: new Date(2017, 0, 11), y: 35 },
                            { x: new Date(2017, 0, 12), y: 45 },
                            { x: new Date(2017, 0, 13), y: 32 },
                            { x: new Date(2017, 0, 14), y: 45 },
                            { x: new Date(2017, 0, 15), y: 65 },
                            { x: new Date(2017, 0, 16), y: 56 }
                        ]
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "독해 점수",
                        lineDashType: "dash",
                        dataPoints: [
                            { x: new Date(2017, 0, 3), y: 45 },
                            { x: new Date(2017, 0, 4), y: 35 },
                            { x: new Date(2017, 0, 5), y: 32 },
                            { x: new Date(2017, 0, 6), y: 45 },
                            { x: new Date(2017, 0, 7), y: 54 },
                            { x: new Date(2017, 0, 8), y: 23 },
                            { x: new Date(2017, 0, 9), y: 45 },
                            { x: new Date(2017, 0, 10), y: 21 },
                            { x: new Date(2017, 0, 11), y: 32 },
                            { x: new Date(2017, 0, 12), y: 12 },
                            { x: new Date(2017, 0, 13), y: 33 },
                            { x: new Date(2017, 0, 14), y: 23 },
                            { x: new Date(2017, 0, 15), y: 56 },
                            { x: new Date(2017, 0, 16), y: 23 }
                        ]
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
    </script>
</head>

<body>

<div class="radio">
    <h3>보기</h3>
    <h4>날짜 순</h4>
    <label><input type="radio" name="optradio" value='1' >일</label>
    <label><input type="radio" name="optradio" value='2' >월</label>
    <label><input type="radio" name="optradio" value='3' >년도</label>
</div>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>

</html>