<div id="history_list" style="margin-left: 10px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>번호</th>
            <th>이름</th>
            <th>날짜</th>
            <th>재시험</th>
            <th>오답노트</th>
            <th>성적표</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>스쿠스쿠3</td>
            <td>2018년 1월 16일</td>
            <td>
                <button class="btn btn-info" id="btn_retest6" onclick="$('#btn_retest6').attr('class','btn-primary').text('응시중');">응시하기</button>
            </td>
            <td>
                <button class="btn btn-info" id="btn_notebook6" onclick="$('#btn_notebook6').attr('class','btn-primary').text('0/5');">출제</button>
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">성적표</button>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>기출문제3</td>
            <td>2018년 1월 15일</td>
            <td>
                <button class="btn btn-info" id="btn_retest5" onclick="$('#btn_retest5').attr('class','btn-primary').text('응시중');">응시하기</button>
            </td>
            <td>
                <button class="btn btn-info" id="btn_notebook5" onclick="$('#btn_notebook5').attr('class','btn-primary').text('0/5');">출제</button>
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">성적표</button>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>스쿠스쿠2</td>
            <td>2018년 1월 14일</td>
            <td>
                <button class="btn btn-info" id="btn_retest4" onclick="$('#btn_retest4').attr('class','btn-primary').text('응시중');">응시하기</button>
            </td>
            <td>
                <button class="btn btn-info" id="btn_notebook4" onclick="$('#btn_notebook4').attr('class','btn-primary').text('0/5');">출제</button>
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">성적표</button>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>기출문제2</td>
            <td>2018년 1월 13일</td>
            <td>
                <button class="btn btn-info" id="btn_retest3" onclick="$('#btn_retest3').attr('class','btn-primary').text('응시중');">응시하기</button>
            </td>
            <td>
                <button class="btn btn-info" id="btn_notebook3" onclick="$('#btn_notebook3').attr('class','btn-primary').text('0/5');">출제</button>
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">성적표</button>
            </td>
        </tr>
        <tr>
            <td>5</td>
            <td>스쿠스쿠1</td>
            <td>2018년 1월 12일</td>
            <td>
                <button class="btn btn-info" id="btn_retest2" onclick="$('#btn_retest2').attr('class','btn-primary').text('응시중');">응시하기</button>
            </td>
            <td>
                <button class="btn btn-info" id="btn_notebook2" onclick="$('#btn_notebook2').attr('class','btn-primary').text('0/5');">출제</button>
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">성적표</button>
            </td>
        </tr>
        <tr>
            <td>6</td>
            <td>기출문제1</td>
            <td>2018년 1월 11일</td>
            <td>
                <button class="btn btn-info" id="btn_retest1" onclick="$('#btn_retest1').attr('class','btn-primary').text('응시중');">응시하기</button>
            </td>
            <td>
                <button class="btn btn-info" id="btn_notebook1" onclick="$('#btn_notebook1').attr('class','btn-primary').text('0/5');">출제</button>
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">성적표</button>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="panel-footer" style="height: 100px;">
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


{{--Modal : make quiz--}}
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1200px">

        <div class="modal-content" style="padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>
            </div>
            <div class="modal-body" style="text-align: left;margin: 0;">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            학생
                        </th>
                        <th>
                            평균점수
                        </th>
                        <th>
                            어휘
                        </th>
                        <th>
                            문법
                        </th>
                        <th>
                            독해
                        </th>
                        <th>
                            갯수
                        </th>
                        <th style="width: 100px">
                            재시험
                        </th>
                        <th style="width: 100px">
                            오답노트
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            김똘똘
                        </td>
                        <td>
                            95
                        </td>
                        <td>
                            32
                        </td>
                        <td>
                            30
                        </td>
                        <td>
                            33
                        </td>
                        <td>
                            19/20
                        </td>
                        <td>
                            <button class="btn-default">미응시</button>
                        </td>
                        <td>
                            <button class="btn-default">미제출</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            최천재
                        </td>
                        <td>
                            100
                        </td>
                        <td>
                            33
                        </td>
                        <td>
                            33
                        </td>
                        <td>
                            33
                        </td>
                        <td>
                            20/20
                        </td>
                        <td>
                            <button class="btn-default">미응시</button>
                        </td>
                        <td>
                            <button class="btn-default">미제출</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            안예민
                        </td>
                        <td>
                            90
                        </td>
                        <td>
                            30
                        </td>
                        <td>
                            30
                        </td>
                        <td>
                            33
                        </td>
                        <td>
                            18/20
                        </td>
                        <td>
                            <button class="btn-default">미응시</button>
                        </td>
                        <td>
                            <button class="btn-default">미제출</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            심사쵸
                        </td>
                        <td>
                            95
                        </td>
                        <td>
                            30
                        </td>
                        <td>
                            33
                        </td>
                        <td>
                            32
                        </td>
                        <td>
                            19/20
                        </td>
                        <td>
                            <button class="btn-default">미응시</button>
                        </td>
                        <td>
                            <button class="btn-default">미제출</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            사라다
                        </td>
                        <td>
                            85
                        </td>
                        <td>
                            28
                        </td>
                        <td>
                            32
                        </td>
                        <td>
                            30
                        </td>
                        <td>
                            17/20
                        </td>
                        <td>
                            <button class="btn-default">미응시</button>
                        </td>
                        <td>
                            <button class="btn-default">미제출</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">학생 점수 인쇄</button>
            </div>
        </div>

        {{--시험 성적표--}}
        <div class="modal-content" style="margin-top: 10px;padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">시험 성적표</h3>
            </div>
            <div class="modal-body" style="text-align: left;margin: 0;">
                <div class="race_and_teacher" style="width: 100%;">
                    <h5 style="margin: 0;text-align:center">
                        <div class="" style="display: inline;margin-right: 10px;">
                        스쿠스쿠3
                        </div>
                        /
                        <div class="" style="display: inline;margin-left: 10px;">
                            t 선생님
                        </div>
                    </h5>
                </div>
                <div class="modal_date" style="width: 100%;text-align: right;"> 2018년 1월 16일</div>

                <div class="detail_record" >
                    <div style="margin: 0">세부 학습 내역</div>
                    <table class="table table-hover">
                        <thead>
                            <tr id="race_detail_record">
                                <th>
                                    학생
                                </th>
                            </tr>
                        </thead>
                        <tbody id="details_record">

                        </tbody>
                    </table>

                    <script>
                        var names = [ "김똘똘", "최천재", "안예민", "심사쵸" , "사라다"];

                        var grade1 = ["o","o","x","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o"];
                        var grade2 = ["o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o"];
                        var grade3 = ["o","o","o","o","o","o","o","o","o","o","o","o","x","o","o","o","x","o","o","o"];
                        var grade4 = ["o","o","x","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o"];
                        var grade5 = ["o","o","x","o","o","o","o","o","o","o","o","o","x","o","o","o","x","o","o","o"];

                        for(var i = 0; i < 20 ; i++){
                            $("#race_detail_record").append($("<th>").text(i+1));
                        }

                        for(var i = 0 ; i < names.length ; i++){
                            $('#details_record').append($('<tr id="'+names[i]+'">').text(names[i]));
                        }

                        for(var i = 0 ; i < grade1.length ; i++){
                            $('#'+names[0]).append($('<td>').text(grade1[i]));
                            $('#'+names[1]).append($('<td>').text(grade2[i]));
                            $('#'+names[2]).append($('<td>').text(grade3[i]));
                            $('#'+names[3]).append($('<td>').text(grade4[i]));
                            $('#'+names[4]).append($('<td>').text(grade5[i]));
                        }

                    </script>

                    <div style="margin: 0">오답 체크 ( 3개 )</div>

                    <table class="table table-hover">
                        <thead>
                        <tr id="race_detail_record">
                            <th style="width: 50px">
                                번호
                            </th>
                            <th colspan="2">
                                문제
                            </th>
                            <th style="width: 100px">
                                오담률<div style="font-size: 0.5px;">sounds like 쿵</div>
                            </th>
                        </tr>
                        </thead>

                        <tbody id="details_record">
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    3
                                </td>
                                <td rowspan="1" colspan="2">
                                    이러쿵 저러쿵 해서 이래요
                                </td>
                                <td rowspan="3" style="border-left: 1px solid transparent;">
                                    3/5
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    정답1
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    정답2
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    정답3
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    정답4
                                </td>
                            </tr>
                        </div>
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    13
                                </td>
                                <td rowspan="1" colspan="2">
                                    이러쿵 저러쿵 해서 이래요
                                </td>
                                <td >
                                    2/5
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    정답1
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    정답2
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    정답3
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    정답4
                                </td>
                            </tr>
                        </div>
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    17
                                </td>
                                <td rowspan="1" colspan="2">
                                    이러쿵 저러쿵 해서 이래요
                                </td>
                                <td>
                                    2/5
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    정답1
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    정답2
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    정답3
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    정답4
                                </td>
                            </tr>
                        </div>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>