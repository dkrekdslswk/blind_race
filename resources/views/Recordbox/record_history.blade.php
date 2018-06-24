<style>
    .record_history {
        z-index: 1;
        position: relative;
        display: block;
        clear: both;
    }
    .recordbox-history {
        margin-top: 40px;
        margin-left: 20px;
        margin-right: 20px;
        padding: 0;
    }
    .historyContainer {
        width: 100%;
    }
    .historyContainer .historyList {
        display: block;
        float: left;
        width: 65%;
    }
    .historyContainer .raceListDetail {
        display: block;
        float: left;
        width: 30%;
        text-align: center;
        height: 70%;
    }
    .historyContainer .raceListDetail .raceListDetailScroll {
        width: 100%;
        height: 100%;
        overflow-y: scroll;
        border: 1px solid #e5e6e8;
    }
    .raceListDetail table thead tr th ,.raceListDetail table tbody {
        text-align: center;
    }

</style>

<script>

    var reqGroupId = "{{$groupId}}";
    var reqWhere = "{{$where}}";

    $(document).ready(function () {
        var raceId = "";
        var userId = "";

        //최근기록 불러오기
        getHistory(reqGroupId);

        //레코드리스트에서 성적표 클릭시 성적표 로드
        $(document).on('click','.history_list_gradeCard button',function () {
            loadGradeCard(this.id);
        });

        //과제 확인하기
        $(document).on('click','.btnHomeworkCheck',function () {
            checkHomework($(this).attr('id'));

        });
    });


    function getHistory(group_id){
        // 요구하는 값
        // $postData = array( 'groupId'   => 1 );

        $('#history_list').empty();

        var reqData = {"groupId" : group_id};
        var raceData = [];

        $.ajax({
            type: 'POST',
            url: "{{url('/recordBoxController/getRaces')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: reqData,
            success: function (data) {

                for( var i = 0 ; i < data['races'].length ; i++ ){
                    $('#history_list').append($('<tr>').attr('id','history_list_tr'+i));
                }

                for( var i = 0 ; i < data['races'].length ; i++ ){

                    $('#history_list_tr'+i).append($('<td>').attr('id','history_id_'+data['races'][i]['raceId'])
                        .text(i+1).attr('value',data['races'][i]['raceId']));

                    $('#history_list_tr'+i).append($('<td>').attr('id','history_name_'+data['races'][i]['raceId'])
                        .text(data['races'][i]['listName']).attr('value',data['races'][i]['listName']));

                    $('#history_list_tr'+i).append($('<td>').text(data['races'][i]['date']));

                    $('#history_list_tr'+i).append($('<td>').attr('class','history_list_gradeCard')
                        .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_RaceGradeCard">')
                            .attr('id',data['races'][i]['raceId'])
                            .text("성적표")));

                    if(data['races'][i]['retestClearCount'] == data['races'][i]['retestCount'] &&
                        data['races'][i]['wrongClearCount'] == data['races'][i]['wrongCount']){

                        $('#history_list_tr'+i).append($('<td>').append($('<button onclick="checkHomework(this.id)">')
                            .attr('class','btn btn-primary').attr('id',data['races'][i]['raceId']).text("전체완료"))
                            .append($('<button>').text("▶").attr('class','btnHomeworkCheck').attr('id',data['races'][i]['raceId'])));
                    }else{
                        $('#history_list_tr'+i).append($('<td>').append($('<button onclick="checkHomework(this.id)">')
                            .attr('class','btn btn-warning').attr('id',data['races'][i]['raceId']).text("미완료"))
                            .append($('<button>').text("▶").attr('class','btnHomeworkCheck').attr('id',data['races'][i]['raceId'])));
                    }


                }

            },
            error: function (data) {
                alert("최근 기록 불러오기 실패");
            }
        });

    }

    //성적표 출력
    function loadGradeCard(raceId){

        var reqData = {'raceId' : raceId};

        $.ajax({
            type: 'POST',
            url: "{{url('/recordBoxController/getStudents')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: reqData,
            success: function (data) {

                //전체 점수와 ���균 점수들 로드하기
                //0은 전체 성적표
                makingModalPage(raceId,data,0);

            },
            error: function (data) {
                alert("학생별 최근 레이스 값 불러오기 에러");
            }
        });
    }


    //해당 레이스안에서 나온 오답들 가져오기
    function getRaceWrongAnswer(raceId) {

        var reqData ={"raceId" : raceId};

        $.ajax({
            type: 'POST',
            url: "{{url('/recordBoxController/getWrongs')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: reqData,
            success: function (data) {
                /*
                 data = { wrongs: {
                                0: { number: 1,
                                    id: 1,
                                    question: "苦労してためたお金なのだから、一円（　　）無駄には使いたくない。",
                                    hint:"3",
                                    type:"obj" or " sub",

                                    rightAnswer:1,
                                    example1:"たりとも",
                                    example2:"とはいえ",
                                    example3:"だけさえ",

                                    userCount:5,
                                    rightAnswerCount:0,
                                    wrongCount:5,
                                    example1Count:0,
                                    example2Count:3,
                                    example3Count:2,
                                    }
                                }
                        }
                */

                var wrongsData = data['wrongs'];
                var leftOrRight = "";
                var allPage = Math.floor(wrongsData.length / 10);

                console.log("wrongs",wrongsData);

                $('.wrong_left').empty();
                $('.wrong_right').empty();
                $('.modal_pagenation').empty();

                if(wrongsData.length == 0){
                    $('.modal_wrong').text("오답 내용이 없습니다.");
                    $('.wrong_left').addClass("noBoardLine");
                    $('.wrong_right').addClass("noBoardLine");
                }else{

                    for(var i = 0 ; i < wrongsData.length ; i++ ){

                        // if(i < 1 ){
                        //     leftOrRight = "wrong_left";
                        //     $('.wrong_right').addClass("noBoardLine");
                        // }
                        // else if(i % 2 == 0 ){
                        //     leftOrRight = "wrong_left";
                        //     $('.wrong_right').removeClass("noBoardLine");
                        // }
                        // else{
                        //     leftOrRight = "wrong_right";
                        //     $('.wrong_right').removeClass("noBoardLine");
                        // }

                        if(i < 5){
                            leftOrRight = "wrong_left";
                            $('.wrong_right').addClass("noBoardLine");
                        }
                        else{
                            leftOrRight = "wrong_right";
                            $('.wrong_right').removeClass("noBoardLine");
                        }

                        //임의로 값 설정
                        //wrongsData[i]['type'] = "sub";


                        switch(wrongsData[i]['type']){
                            case "obj" :

                                /***************************************************************************/
                                wrongsData[0]['question'] = "苦労してためたお金なのだから、一円（　　）無駄には使いたくない。";
                                wrongsData[0]['rightAnswer'] = "とはいえ";
                                wrongsData[0]['example1'] = "たりとも";
                                wrongsData[0]['example2'] = "ばかりも";
                                wrongsData[0]['example3'] = "だけさえ";
                                wrongsData[2]['question'] = "この店は洋食と和食の両方が楽しめる（　　）、お得意さんが多い。";
                                wrongsData[2]['rightAnswer'] = "とあって";
                                wrongsData[2]['example1'] = "からして";
                                wrongsData[2]['example2'] = "にあって";
                                wrongsData[2]['example3'] = "にしては";
                                wrongsData[4]['question'] = "姉は市役所に勤める（　　）、ボランティアで日本語を教えています。";
                                wrongsData[4]['rightAnswer'] = "かたわら";
                                wrongsData[4]['example1'] = "かたがた";
                                wrongsData[4]['example2'] = "こととて";
                                wrongsData[4]['example3'] = "うちに";
                                /***************************************************************************/

                                $('.' + leftOrRight).append($('<div>').attr('class','objWrong')
                                    .append($('<table>').attr('class', 'table_wrongList')
                                        .append($('<thead>')
                                            .append($('<tr>')
                                                .append($('<th>')
                                                    .append($('<div>').text(wrongsData[i]['number'])
                                                    )
                                                )
                                                .append($('<th>')
                                                    .append($('<div>')
                                                        .append($('<b>').text(wrongsData[i]['question'])
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                        .append($('<tbody>')
                                            .append($('<tr>')
                                                .append($('<td colspan="2">')
                                                    .append($('<div>').attr('class','wrongExamples')
                                                        .append($('<ul>')
                                                            .append($('<li>').text(wrongsData[i]['rightAnswer']+" ("+ wrongsData[i]['rightAnswerCount'] +"명)"))
                                                            .append($('<li>').text(wrongsData[i]['example1']+" ("+ wrongsData[i]['example1Count'] +"명)"))
                                                            .append($('<li>').text(wrongsData[i]['example2']+" ("+ wrongsData[i]['example2Count'] +"명)"))
                                                            .append($('<li>').text(wrongsData[i]['example3']+" ("+ wrongsData[i]['example3Count'] +"명)")
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                );

                                break;
                            case "sub" :
                                /***************************************************************************/
                                wrongsData[1]['question'] = "周辺の住民がいくら反対した（　　）、動きだした開発計画は止まらないだろう。";
                                wrongsData[1]['rightAnswer'] = "ところで";
                                wrongsData[1]['hint'] = "とこ@で";
                                wrongsData[3]['question'] = "苦労してためたお金なのだから、一円（　　）無駄には使いたくない。";
                                wrongsData[3]['rightAnswer'] = "たりとも";
                                wrongsData[3]['hint'] = "@@とも";
                                wrongsData[5]['question'] = "姉は市役所に勤める（　　）、ボランティアで日本語を教えています。";
                                wrongsData[5]['rightAnswer'] = "かたわら";
                                wrongsData[5]['hint'] = "か@@@";
                                /***************************************************************************/
                                $('.' + leftOrRight).append($('<div>').attr('class','subWrong')
                                    .append($('<table>').attr('class', 'table_wrongList')
                                        .append($('<thead>')
                                            .append($('<tr>')
                                                .append($('<th>')
                                                    .append($('<div>').text(wrongsData[i]['number'])
                                                    )
                                                )
                                                .append($('<th>')
                                                    .append($('<div>')
                                                        .append($('<b>').text(wrongsData[i]['question'])
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                        .append($('<tbody>')
                                            .append($('<tr>')
                                                .append($('<td colspan="2">')
                                                    .append($('<div>').attr('class','wrongExamples')
                                                        .append($('<h4>').text("정답 : "+wrongsData[i]['rightAnswer']+" ("+ wrongsData[i]['rightAnswerCount'] +"명)")
                                                        )
                                                        .append($('<div>').text("힌트 : "+wrongsData[i]['hint']).css('color','blue')
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                );
                                break;
                        }

                    }

                    allPage = 3;
                    $('#modalPagenation').append($('<div>').attr('class','wrong_page'));
                    for(var i = 0 ; i <= allPage ; i++){
                        $('.wrong_page').append($('<a href="#">').val(i+1).text(i+1));
                    }
                }

            },
            error: function (data) {
                alert("해당 레이스별 오답 문제 가져오기");
            }
        });

    }


    //레이스 이름 클릭시 학생들 과제 상태 체크
    function checkHomework(raceId){
        // 요구하는 값
        /*            $postData = array(
                        'raceId'    => 1
                );*/
        var reqData = {'raceId' : raceId};

        $.ajax({
            type: 'POST',

            url: "{{url('/recordBoxController/homeworkCheck')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: reqData,
            success: function (data) {

                // data = {
                //     group: {id: 1, name: "3WDJ"},
                //     students: {
                //         0: {
                //             userId: 1300000
                //             userName: "김똘똘"
                //
                //             retestState: "not"
                //             wrongState: "not"
                //         }

                //          1: {
                //             userId: 1300000
                //             userName: "김똘똘"
                //
                //             retestState: "not"
                //             wrongState: "not"
                //         }
                //      }
                // }

                var stdHomework = data['students'];
                $('#historyListNumber').empty();
                $('#historyListRaceName').empty();
                $('#history_homework').empty();

                for (var i = 0; i < stdHomework.length ; i ++) {

                    if(stdHomework[i]['wrongState'] == "not" && stdHomework[i]['retestState'] == "not"){
                        $('#history_homework').append($('<tr id="history_homework_tr' + i + '">'));

                        $('#historyListNumber').text($('#history_id_'+raceId).attr('value'));
                        $('#historyListRaceName').text($('#history_name_'+raceId).attr('value'));

                        $('#history_homework_tr' + i).append($('<td>').attr('colspan',3).text("해당 학생 없음"));

                    }else{

                        $('#history_homework').append($('<tr id="history_homework_tr' + i + '">'));

                        $('#historyListNumber').text($('#history_id_'+raceId).attr('value'));
                        $('#historyListRaceName').text($('#history_name_'+raceId).attr('value'));

                        $('#history_homework_tr' + i).append($('<td>').text(stdHomework[i]['userName']));

                        switch (stdHomework[i]['retestState']){
                            case "not" :
                                $('#history_homework_tr' + i).append($('<td>').text("PASS"));

                                break;
                            case "order" :
                                $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미응시")));

                                break;
                            case "clear" :
                                $('#history_homework_tr' + i).append($('<td>').attr('class','modal_openStudentRetestGradeCard')
                                    .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_RaceGradeCard">')
                                        .attr('id',raceId).attr('name',stdHomework[i]['userId']).text("응시완료")));

                                break;
                        }

                        //임의로 값 설정
                        stdHomework[i]['wrongState'] = "clear";

                        switch (stdHomework[i]['wrongState']){
                            case "not" :
                                $('#history_homework_tr' + i).append($('<td>').text("PASS"));

                                break;
                            case "order" :
                                $('#history_homework_tr' + i).append($('<td>').append($('<button>').attr('class', 'btn btn-warning').text("미제출")));

                                break;
                            case "clear" :
                                $('#history_homework_tr' + i).append($('<td>').attr('class','modal_openStudentWrongGradeCard')
                                    .append($('<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_RaceGradeCard">')
                                        .attr('id',raceId).attr('name',stdHomework[i]['userId']).text("제출완료")));

                                break;
                        }
                    }
                }

            },
            error: function (data) {
                alert("과제 조회 에러2");
            }
        });
    }

    function makingChartData(raceData) {

        var raceData = raceData['races'];


        var total_data_Points = [];
        var grammer_data_Points = [];
        var vocabulary_Points = [];
        var word_data_Points = [];
        var AllChartData = [];

        for(var i = 0 ; i < raceData.length ; i++){

            //총점 구하기
            var total_grade = ((100 / raceData[i]['quizCount']).toFixed(1) *  raceData[i]['rightAnswerCount']).toFixed(0);

            //문법 총점 구하기
            var grammer_grade = ((33 / raceData[i]['grammarCount']).toFixed(1) *  raceData[i]['grammarRightAnswerCount']).toFixed(0);

            //어휘 총점 구하기
            var vocabulary_grade = ((33 / raceData[i]['vocabularyCount']).toFixed(1) *  raceData[i]['vocabularyRightAnswerCount']).toFixed(0);

            //단어 총점 구하기
            var word_grade = ((33 / raceData[i]['wordCount']).toFixed(1) *  raceData[i]['wordRightAnswerCount']).toFixed(0);

            //차트 데이터 배열 만들기
            total_data_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                y : parseInt(total_grade) ,
                label : raceData[i]['listName']});

            grammer_data_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                y : parseInt(grammer_grade) ,
                label : raceData[i]['listName']});

            vocabulary_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                y : parseInt(vocabulary_grade) ,
                label : raceData[i]['listName']});

            word_data_Points.push({ x : new Date(raceData[i]['date'].replace('-','/','g')),
                y : parseInt(word_grade) ,
                label : raceData[i]['listName']});
        }

        //차트 데이터 합치기
        AllChartData = { "total_data" : ["전체 평균 점수" , total_data_Points] ,
            "voca_data" : ["어학 점수", vocabulary_Points] ,
            "grammer_data" : ["독해 점수" , grammer_data_Points] ,
            "word_data" : ["단어 점수" , word_data_Points]
        };

        return AllChartData;
    }


    function makingStudentChartData(data){

        var total_data_Points = [];
        var grammer_data_Points = [];
        var vocabulary_Points = [];
        var word_data_Points = [];
        var AllChartData = [];
        var categoryCount = 0;
        var gradeByOne = 0;
        var makingStudentData;

        var parseData = JSON.parse(JSON.stringify(data['races']));

        //변수 접근은 .
        //배열 접근은 ['']
        for(var i = 0 ; i < parseData.length ; i++){
            makingStudentData = JSON.parse(parseData[i]);

            gradeByOne = Math.floor(100 / makingStudentData.allCount);

            //문법 총점 구하기
            var grammar_grade = gradeByOne * makingStudentData.grammarRightCount;

            //어휘 총점 구하기
            var vocabulary_grade = gradeByOne * makingStudentData.vocabularyRightCount;

            //단어 총점 구하기
            var word_grade = gradeByOne * makingStudentData.wordRightCount;

            //총점 구하기
            var total_grade = grammar_grade + vocabulary_grade + word_grade;

            //차트 데이터 배열 만들기
            total_data_Points.push({ x      : new Date(makingStudentData['date']),
                y      : parseInt(total_grade) ,
                label  : makingStudentData['listName']});

            grammer_data_Points.push({ x    : new Date(makingStudentData['date']),
                y    : parseInt(grammar_grade) ,
                label: makingStudentData['listName']});

            vocabulary_Points.push({ x      : new Date(makingStudentData['date']),
                y      : parseInt(vocabulary_grade) ,
                label  : makingStudentData['listName']});

            word_data_Points.push({ x       : new Date(makingStudentData['date']),
                y       : parseInt(word_grade) ,
                label   : makingStudentData['listName']});
        }

        //차트 데이터 합치기
        AllChartData = { "total_data"   : ["전체 평균 점수" , total_data_Points] ,
            "voca_data"    : ["어학 점수", vocabulary_Points] ,
            "grammer_data" : ["독해 점수" , grammer_data_Points] ,
            "word_data"    : ["단어 점수" , word_data_Points]
        };

        return AllChartData;
    }

    //차트 만들 데이터
    function makingChart(data){

        //data = { "total_data" : [ "전체 평균 점수" , { x: new Date(0,0,0) , y: 80 , label: "문제 : 스쿠스쿠"}]}
        //data['total_data'] , data['voca_data'] , data['grammer_data'] , data['word_data']
        //data['total_data'][0]     ==  "전체 평균 점수"
        //data['total_data'][1]     == {x , y , label}

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{},
            axisX:{
                labelFontSize: 15,
                valueFormatString: "MM월 DD일 (HH:ss)",
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
                horizontalAlign: "center",
                itemclick: toogleDataSeries
            },
            data: [{
                type: "line",
                showInLegend: true,
                xValueFormatString: "DD, DD MMM, YYYY, HH, mm ,ss",
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

</script>

<div class="recordbox-history">
    <div class="historyContainer">

        <div class="historyList">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>번호</th>
                    <th>퀴즈 제목</th>
                    <th>날짜</th>
                    <th>성적표</th>
                    <th>과제 확인하기</th>
                </tr>
                </thead>
                <tbody id="history_list">
                </tbody>
            </table>

            <div class="panel-footer" style="height: 80px;">
                <div class="row">
                    <div class="col col-xs-4">Page 1 of 5
                    </div>
                    <div class="col col-xs-8">
                        <ul class="pagination hidden-xs pull-right">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                        </ul>
                        <ul class="pagination visible-xs pull-right">
                            <li><a href="#">«</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: block;float: left;margin: 2%;">
        </div>

        {{--과제 목록 보기--}}
        <div class="raceListDetail">
            <div class="raceListDetailScroll">
                <table class="table table-hover table-bordered table-striped" >
                    <thead>
                    <tr>
                        <th id="historyListNumber">
                            번호
                        </th>
                        <th id="historyListRaceName" colspan="2">
                            퀴즈제목
                        </th>
                    </tr>
                    <tr>
                        <th>
                            학생
                        </th>
                        <th>
                            재시험
                        </th>
                        <th>
                            오답노트
                        </th>
                    </tr>
                    </thead>

                    {{--getStudent()로 학생들 불러오기--}}
                    <tbody id="history_homework">

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
