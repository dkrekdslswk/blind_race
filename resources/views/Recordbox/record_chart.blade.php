
<head>
    <style>
        .record_chart{
            z-index: 1;
            position: relative;
            display: block;
            text-align: center;
            clear: both;
        }
        .chartAttribute {
            height : 120px;
            width: 100%;
        }
        .attributeContainer {
            margin: auto;
            width: 80%;
            text-align: center;
        }
        .recordbox-radio{
            display: block;
            height: 100%;
            float:left;
            margin:0;
            vertical-align: middle;
        }
        .chooseDate {
            display: block;
            height: 100%;
            float:right;
            margin-right:7%;
            vertical-align: middle;
        }
        .recordbox-radio h3,.chooseDate h3{
            margin-left: 10px;
            margin-right: 10px;
        }
        .recordbox-radioButtons {
            vertical-align: middle;
        }
        .recordbox-radioButtons label{
            margin-left: 20px;
            margin-right: 20px;
        }
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
        .chartArea{
            height: 400px;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .chartWrapper {
            margin-left: 10%;
            margin-right: 10%;
            width: 80%;
            height: 100%;
        }
        .chartAreaWrapper {
            margin: 0;
            width: 100%;
            height: 100%;
            overflow-x: scroll;
        }
        .canvaschart{
            position: relative;
            padding-top: 10px;
            left: 0;
            top: 0;
            width: 100%;
            height: 95%;
            margin: 0;
        }

    </style>

</head>

<div class="record_chart">
    <div class="recordbox-chartContainer">

        <div class="chartAttribute">

            <div class="attributeContainer">

                <div class="recordbox-radio">
                    <h3>보기</h3>

                    <div class="recordbox-radioButtons">
                        <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='1' checked="checked">일주일</label>
                        <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='2' >한달</label>
                        <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='3' >3개월</label>
                        <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='4' >6개월</label>
                        <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='5' >12개월</label>
                    </div>
                </div>

                <div class="chooseDate" >
                    <h3>기간</h3>

                    <input type="date" name="chooseday" id="startDate"></input>

                    <input type="date" name="chooseday" id="endDate"></input>

                    <button class="btn btn-default" onclick="orderChart()">
                        조회
                    </button>
                </div>
            </div>
        </div>


        <div class="chartArea">
            <div class="chartWrapper">
                <div class="chartAreaWrapper">
                    <div class="canvaschart" id="chartContainer"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
