<!-- Made by Minsu -->
<link href="js/bootstrap.min.js" rel="stylesheet">
<link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">

    #curve_chart {
        margin-top: 1em;
    }
</style>
<div id="mid_content" style="margin-left:15%">
    <div class="jumbotron" >
        <h1 id="quiz_number" class="display-3">1번</h1>
        <a id="Mid_skip_btn" class="btn btn-primary btn-lg nextbutton" href="#" role="button">다음문제 넘어가기</a>
    </div>
    <section>
        <div class="divss">
            <div id="Mid_Q_Name"class="well well-lg ">문제</div>
            <div id="Mid_A_Right" class="well well-lg">정덥</div>
        </div>

        <div class="pieID pie"></div>
        <h4 id="winners" class="pieID"></h4>
        <ul class="pieID legend" style="display:none;">

            <li>
                <em>1번</em>
                <span id="right">10</span>
            </li>
            <li>
                <em>2번</em>
                <span id="wrong">25</span>
            </li>

        </ul>

    </section>
</div>
<style>
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);

    @keyframes bake-pie {
        from {
            transform: rotate(0deg) translate3d(0,0,0);
        }
    }

    body {
        font-family: "Open Sans", Arial;
        background: #EEE;
    }
    main {
        width: 400px;
        margin: 30px auto;
    }
    section {
        margin-top: 30px;
    }
    .pieID {
        display: inline-block;
        vertical-align: top;
    }
    .pie {
        height: 200px;
        width: 200px;
        position: relative;
        margin: 0 30px 30px 0;
    }
    .pie::before {
        text-align: center;
        font-size: 20pt;
        content: "100";
        display: block;
        position: absolute;
        z-index: 1;
        width: 100px;
        height: 100px;
        background: #EEE;
        border-radius: 50%;
        top: 50px;
        left: 50px;
        line-height:100px;
    }
    .pie::after {
        content: "";
        display: block;
        width: 120px;
        height: 2px;
        background: rgba(0,0,0,0.1);
        border-radius: 50%;
        box-shadow: 0 0 3px 4px rgba(0,0,0,0.1);
        margin: 220px auto;

    }
    .slice {
        position: absolute;
        width: 200px;
        height: 200px;
        clip: rect(0px, 200px, 200px, 100px);
        animation: bake-pie 1s;
    }
    .slice span {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        background-color: black;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        clip: rect(0px, 200px, 200px, 100px);
    }
    .legend {
        list-style-type: none;
        padding: 0;
        margin: 0;
        background: #FFF;
        padding: 15px;
        font-size: 13px;
        box-shadow: 1px 1px 0 #DDD, 2px 2px 0 #BBB;
    }
    .legend li {
        width: 110px;
        height: 1.25em;
        margin-bottom: 0.7em;
        padding-left: 0.5em;
        border-left: 1.25em solid black;
    }
    .legend em {
        font-style: normal;
    }
    .legend span {
        float: right;
    }
    footer {
        position: fixed;
        bottom: 0;
        right: 0;
        font-size: 13px;
        background: #DDD;
        padding: 5px 10px;
        margin: 5px;
    }

    .progress {
        width: 150px;
        height: 150px;
        line-height: 150px;
        background: none;
        margin: 0 auto;
        box-shadow: none;
        position: relative;
    }
    .progress:after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 12px solid #fff;
        position: absolute;
        top: 0;
        left: 0;
    }
    .progress > span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }
    .progress .progress-left {
        left: 0;
    }
    .progress .progress-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 12px;
        border-style: solid;
        position: absolute;
        top: 0;
    }
    .progress .progress-left .progress-bar {
        left: 100%;
        border-top-right-radius: 80px;
        border-bottom-right-radius: 80px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }
    .progress .progress-right {
        right: 0;
    }
    .progress .progress-right .progress-bar {
        left: -100%;
        border-top-left-radius: 80px;
        border-bottom-left-radius: 80px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
        animation: loading-1 1.8s linear forwards;
    }
    .progress .progress-value {
        width: 90%;
        height: 90%;
        border-radius: 50%;
        background: #44484b;
        font-size: 24px;
        color: #fff;
        line-height: 135px;
        text-align: center;
        position: absolute;
        top: 5%;
        left: 5%;
    }
    .progress.blue .progress-bar {
        border-color: #049dff;
    }
    .progress.blue .progress-left .progress-bar {
        animation: loading-2 1.5s linear forwards 1.8s;
    }

    .progress.pink .progress-bar {
        border-color: #ed687c;
    }
    .progress.pink .progress-left .progress-bar {
        animation: loading-4 0.4s linear forwards 1.8s;
    }
    .progress.green .progress-bar {
        border-color: #1abc9c;
    }
    .progress.green .progress-left .progress-bar {
        animation: loading-5 1.2s linear forwards 1.8s;
    }
    @keyframes loading-1 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }
    }
    @keyframes loading-2 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(144deg);
            transform: rotate(144deg);
        }
    }
    @keyframes loading-3 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }
    }
    @keyframes loading-4 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(36deg);
            transform: rotate(36deg);
        }
    }
    @keyframes loading-5 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(126deg);
            transform: rotate(126deg);
        }
    }
    @media only screen and (max-width: 990px) {
        .progress {
            margin-bottom: 20px;
        }
    }
    .well {
        width: 600px;
        min-height: 120px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.05);

    }

    .divss {
        display: inline-block;
    }
    .nextbutton {
        margin-left: 550px;
    }
</style>

// <script>

    // function sliceSize(dataNum, dataTotal) {
    //     return (dataNum / dataTotal) * 360;
    // }
    // function addSlice(sliceSize, pieElement, offset, sliceID, color) {
    //     $(pieElement).append(
    //         "<div class='slice " + sliceID + "'><span></span></div>"
    //     );
    //     var offset = offset - 1;
    //     var sizeRotation = -179 + sliceSize;
    //     $("." + sliceID).css({
    //         "transform": "rotate(" + offset + "deg) translate3d(0,0,0)"
    //     });
    //     $("." + sliceID + " span").css({
    //         "transform": "rotate(" + sizeRotation + "deg) translate3d(0,0,0)",
    //         "background-color": color
    //     });
    // }
    // function iterateSlices(
    //     sliceSize,
    //     pieElement,
    //     offset,
    //     dataCount,
    //     sliceCount,
    //     color
    // ) {
    //     var sliceID = "s" + dataCount + "-" + sliceCount;
    //     var maxSize = 179;
    //     if (sliceSize <= maxSize) {
    //         addSlice(sliceSize, pieElement, offset, sliceID, color);
    //     } else {
    //         addSlice(maxSize, pieElement, offset, sliceID, color);
    //         iterateSlices(
    //             sliceSize - maxSize,
    //             pieElement,
    //             offset + maxSize,
    //             dataCount,
    //             sliceCount + 1,
    //             color
    //         );
    //     }
    // }
    // function createPie(dataElement, pieElement) {
    //     var listData = [];
    //     $(dataElement + " span").each(function () {
    //         listData.push(Number($(this).html()));
    //     });
    //     var listTotal = 0;
    //     for (var i = 0; i < listData.length; i++) {
    //         listTotal += listData[i];
    //     }
    //     var offset = 0;
    //     var color = [
    //         "green",
    //         "red",
    //         "orange",
    //         "tomato",
    //         "crimson",
    //         "purple",
    //         "turquoise",
    //         "forestgreen",
    //         "navy",
    //         "gray"
    //     ];
    //     for (var i = 0; i < listData.length; i++) {
    //         var size = sliceSize(listData[i], listTotal);
    //         iterateSlices(size, pieElement, offset, i, 0, color[i]);
    //         $(dataElement + " li:nth-child(" + (
    //             i + 1
    //         ) + ")").css("border-color", color[i]);
    //         offset += size;
    //     }
    // }
    // createPie(".pieID.legend", ".pieID.pie");
    // </script>