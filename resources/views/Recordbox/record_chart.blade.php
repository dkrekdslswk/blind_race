
<head>
    <style>
        .chart_total {
            color: #f08080;
        }
        .chart_vocabulary {
            color: #51cda0;
        }
        .chart_grammer {
            color: #df7970;
        }
        .chart_word {
            color: #4c9ca0;
        }

        .chartWrapper {
            position: relative;
            max-width: 1400px;
            height: 650px;
            overflow-x: scroll;
            overflow-y: hidden;
        }
        .chartAreaWrapper {
            margin: 0;
            width: 600px;
        }
        .canvaschart{
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 600px;
            margin: 0;
        }

    </style>

    <script>

        //차트 만들기 원본
        /*function makingChart(id,axisXType){
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
                }
                ,
                axisY: {
                    crosshair: {
                        enabled: false
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
                    name: "전체 평균 점수",
                    markerType: "square",
                    xValueFormatString: "DD, MMM, DD MMM, YYYY",
                    color: "#F08080",
                    toolTipContent: "{name}",
                    dataPoints: [
                        { x: new Date(2016, 12, 28), y: 70},
                        { x: new Date(2016, 12, 29), y: 71},
                        { x: new Date(2016, 12, 30), y: 73},
                        { x: new Date(2017, 1, 1), y: 72},
                        { x: new Date(2017, 1, 2), y: 70},
                        { x: new Date(2017, 1, 3), y: 65},
                        { x: new Date(2017, 1, 4), y: 70 },
                        { x: new Date(2017, 1, 5), y: 71 },
                        { x: new Date(2017, 1, 6), y: 70 },
                        { x: new Date(2017, 1, 7), y: 73 },
                        { x: new Date(2017, 1, 8), y: 80 },
                        { x: new Date(2017, 1, 9), y: 84 },
                        { x: new Date(2017, 1, 10), y: 85 },
                        { x: new Date(2017, 1, 11), y: 86 , name: "문제 : 스쿠스쿠1" },
                        { x: new Date(2017, 1, 12), y: 94 , name: "문제 : 기출문제1" },
                        { x: new Date(2017, 1, 13), y: 97 , name: "문제 : 스쿠스쿠2" },
                        { x: new Date(2017, 1, 14), y: 86 , name: "문제 : 기출문제2" },
                        { x: new Date(2017, 1, 15), y: 89 , name: "문제 : 스쿠스쿠3" },
                        { x: new Date(2017, 1, 16), y: 93 , name: "문제 : 기출문제3" }
                    ]
                },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "어학 점수",
                        lineDashType: "dash",
                        dataPoints: [
                            { x: new Date(2016, 12, 28), y: 23},
                            { x: new Date(2016, 12, 29), y: 22},
                            { x: new Date(2016, 12, 30), y: 21},
                            { x: new Date(2017, 1, 1), y: 20},
                            { x: new Date(2017, 1, 2), y: 22},
                            { x: new Date(2017, 1, 3), y: 23},
                            { x: new Date(2017, 1, 4), y: 24 },
                            { x: new Date(2017, 1, 5), y: 26 },
                            { x: new Date(2017, 1, 6), y: 25 },
                            { x: new Date(2017, 1, 7), y: 28 },
                            { x: new Date(2017, 1, 8), y: 32 },
                            { x: new Date(2017, 1, 9), y: 30 },
                            { x: new Date(2017, 1, 10), y: 32 },
                            { x: new Date(2017, 1, 11), y: 34 , name: "문제 : 스쿠스쿠1" },
                            { x: new Date(2017, 1, 12), y: 35 , name: "문제 : 기출문제1" },
                            { x: new Date(2017, 1, 13), y: 36 , name: "문제 : 스쿠스쿠2" },
                            { x: new Date(2017, 1, 14), y: 32 , name: "문제 : 기출문제2" },
                            { x: new Date(2017, 1, 15), y: 30 , name: "문제 : 스쿠스쿠3" },
                            { x: new Date(2017, 1, 16), y: 32 , name: "문제 : 기출문제3" }
                        ]
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "문법 점수",
                        lineDashType: "dash",
                        dataPoints: [
                            { x: new Date(2016, 12, 28), y: 21},
                            { x: new Date(2016, 12, 29), y: 20},
                            { x: new Date(2016, 12, 30), y: 22},
                            { x: new Date(2017, 1, 1), y: 23},
                            { x: new Date(2017, 1, 2), y: 22},
                            { x: new Date(2017, 1, 3), y: 21},
                            { x: new Date(2017, 1, 4), y: 19 },
                            { x: new Date(2017, 1, 5), y: 23 },
                            { x: new Date(2017, 1, 6), y: 25 },
                            { x: new Date(2017, 1, 7), y: 24 },
                            { x: new Date(2017, 1, 8), y: 22 },
                            { x: new Date(2017, 1, 9), y: 20 },
                            { x: new Date(2017, 1, 10), y: 23 },
                            { x: new Date(2017, 1, 11), y: 22 },
                            { x: new Date(2017, 1, 12), y: 25 , name: "문제 : 스쿠스쿠1" },
                            { x: new Date(2017, 1, 13), y: 27 , name: "문제 : 기출문제1" },
                            { x: new Date(2017, 1, 14), y: 28 , name: "문제 : 스쿠스쿠2" },
                            { x: new Date(2017, 1, 15), y: 32 , name: "문제 : 기출문제2" },
                            { x: new Date(2017, 1, 16), y: 30, name: "문제 : 기출문제3" }
                        ]
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "독해 점수",
                        lineDashType: "dash",
                        dataPoints: [
                            { x: new Date(2016, 12, 28), y: 20},
                            { x: new Date(2016, 12, 29), y: 21},
                            { x: new Date(2016, 12, 30), y: 22},
                            { x: new Date(2017, 1, 1), y: 19},
                            { x: new Date(2017, 1, 2), y: 20},
                            { x: new Date(2017, 1, 3), y: 21},
                            { x: new Date(2017, 1, 4), y: 23 },
                            { x: new Date(2017, 1, 5), y: 20 },
                            { x: new Date(2017, 1, 6), y: 24 },
                            { x: new Date(2017, 1, 7), y: 26 },
                            { x: new Date(2017, 1, 8), y: 25 },
                            { x: new Date(2017, 1, 9), y: 27 },
                            { x: new Date(2017, 1, 10), y: 29 },
                            { x: new Date(2017, 1, 11), y: 32 , name: "문제 : 스쿠스쿠1" },
                            { x: new Date(2017, 1, 12), y: 30 , name: "문제 : 기출문제1" },
                            { x: new Date(2017, 1, 13), y: 29 , name: "문제 : 스쿠스쿠2" },
                            { x: new Date(2017, 1, 14), y: 31 , name: "문제 : 기출문제2" },
                            { x: new Date(2017, 1, 15), y: 32 , name: "문제 : 스쿠스쿠3" },
                            { x: new Date(2017, 1, 16), y: 33 , name: "문제 : 기출문제3" }
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
        }*/

    </script>
</head>

<body>

    <div class="radio">
        <h3>보기</h3>
        <label><input type="radio" checked="checked" id="radio_1" name="optradio" onclick="changeDateToChart()" value='1'>일주일</label>
        <label><input type="radio" id="radio_2" name="optradio" onclick="changeDateToChart()" value='2' >한달</label>
        <label><input type="radio" id="radio_3" name="optradio" onclick="changeDateToChart()" value='3' >3개월</label>
        <label><input type="radio" id="radio_4" name="optradio" onclick="changeDateToChart()" value='4' >6개월</label>
        <label><input type="radio" id="radio_5" name="optradio" onclick="changeDateToChart()" value='5' >12개월</label>
    </div>

    <div class="chooseDate" style="margin-bottom: 30px;">
        <h3>기간</h3>

        <input type="date" name="chooseday" id="startDate"></input>

        <input type="date" name="chooseday" id="endDate"></input>

        <button class="btn btn-default" onclick="orderChart()">
            조회
        </button>
    </div>

    <div class="chartWrapper">
        <div class="chartAreaWrapper">
            <div class="canvaschart" id="chartContainer"></div>
        </div>
    </div>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
