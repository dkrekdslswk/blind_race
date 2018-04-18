<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Record Box</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style type="text/css">

        .RecordBar {
            text-align: left;
            margin-bottom: 20px;
            margin-left: 10%;
        }

        .RecordBar blank {
            margin-left: 28%;
            margin-right: 28%;
            display: inline;
        }

        .panel-table .panel-body{
            padding:0;
        }

        .panel-table .panel-body .table-bordered{
            border-style: none;
            margin:0;
            text-align: center;
        }

        .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
            text-align:center;
            width: 150px;
        }

        .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
        .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
            border-right: 0px;
        }

        .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
        .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
            border-left: 0px;
        }

        .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
            border-bottom: 0px;
        }

        .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
            border-top: 0px;
        }

        .panel-table .panel-footer .pagination{
            margin:0;
        }

        /*
        used to vertically center elements, may need modification if you're not using default sizes.
        */
        .panel-table .panel-footer .col{
            line-height: 34px;
            height: 34px;
        }

        .panel-table .panel-heading .col h3{
            line-height: 30px;
            height: 30px;
        }

        .panel-table .panel-body .table-bordered > tbody > tr > td{
            line-height: 34px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
                        var $tbody = $('<tr id/>').appendTo('#list');
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
                            width: 1300,
                            height: 400,
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

    <nav>
        @include('Navigation.main_nav')
    </nav>


    <div class="record_page">

        {{--그룹 선택 , 문제 유형 , 학습 기록 조회 , 피드백과 질문--}}

        <div id="record_bar" class="RecordBar">
            <button type="button" class="btn btn-primary" style="display: inline;" >그룹 선택</button>
            <select id="bookSelect" >
                <blank></blank>
                <option value="1">특강 A반</option>
                <option value="2">특강 B반</option>
                <option value="3">특강 C반</option>
            </select>
            <button type="button" class="btn btn-primary" style="display: inline;" >문제 유형</button>
            <select id="bookSelect" >
                <blank></blank>
                <option value="1">레이스</option>
                <option value="2">골든벨</option>
            </select>

            <blank></blank>

            <button class="btn btn-default" style="margin-bottom: 5px" onclick="location.href='/recordbox'">
                학습 기록 조회
            </button>
            <button class="btn btn-default" onclick="location.href='/feedback'">
                피드백과 질문
            </button>
        </div>


        {{--그래프 출력--}}
        <div id="curve_chart" class="chart"></div>

        {{--학생들 성적 테이블--}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <h3 class="panel-title">학생들 개인 성적</h3>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th style="text-align:center">이름</th>
                                    <th style="text-align: center">시험점수</th>
                                    <th style="text-align: center">레이스</th>
                                    <th style="text-align: center">오답노트</th>
                                    <th style="text-align: center">재시험</th>
                                </tr>
                            </thead>

                            <tbody id="list">

                            {{--받아온 정보를 입력--}}

                            </tbody>
                        </table>
                    </div>

                    <div class="panel-footer">
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
            </div>
        </div>

        {{--Modal : select group--}}
        {{--    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="#"  method="Post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="groupId" id="groupId" value="">
                        <input type="hidden" name="raceMode" id="raceMode" value="n">
                        <input type="hidden" name="examCount" id="examCount" value="0">
                        <input type="hidden" name="raceId" id="raceId" value="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabel">피드백</h5>
                            </div>

                            <div>
                                오늘 푼 스쿠스쿠 퀴즈 3번 문제 답이<br>
                                왜 1번인지 이해가 안갑니다.<br>
                                4번이 해석에 더 맞지 않을까요? <br>
                            </div>
                            <hr>
                            <div>답변</div>
                            <textarea rows="5" cols="80" name="contents" style="resize: none;"></textarea>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">확인</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>--}}

    </div>
</body>
</html>

