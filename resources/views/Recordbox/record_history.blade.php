<div id="history_list" style="width: 1000px;float: left;margin-left: 100px;">
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
                0 / 4
            </td>
            <td>
                 0 / 4
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#Modal">성적표</button>
            </td>
        </tr>
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


<div style="float: left;margin-top: 50px;margin-left: 50px;margin-right: 50px;">
    >
</div>

{{--과제 목록 보기--}}
<div class="raceListDetail" style="width: 400px;float: left;">
    <table class="table table-hover table-bordered table-striped" >
        <thead>
        <tr>
            <th width="50px">
                번호
            </th>
            <th>
                학생
            </th>
            <th width="110px">
                재시험
            </th>
            <th width="110px">
                오답노트
            </th>
        </tr>
        </thead>

        {{--getStudent()로 학생들 불러오기--}}
        <tbody>
        <tr>
            <td width="50px">
                1
            </td>
            <td>
                최천재
            </td>
            <td width="90px">
                <button class="btn btn-primary"> 응시</button>
            </td>
            <td width="90px">
                <button class="btn btn-primary"> 제출</button>
            </td>
        </tr>
        <tr>
            <td width="50px">
                2
            </td>
            <td>
                안예민
            </td>
            <td width="90px">
                <button class="btn btn-warning"> 미응시</button>

            </td>
            <td width="90px">
                <button class="btn btn-warning"> 미제출</button>

            </td>
        </tr>
        <tr>
            <td width="50px">
                3
            </td>
            <td>
                심사쵸
            </td>
            <td width="90px">
                <button class="btn btn-warning"> 미응시</button>

            </td>
            <td width="90px">
                <button class="btn btn-warning"> 미제출</button>

            </td>
        </tr>
        <tr>
            <td width="50px">
                4
            </td>
            <td>
                사라다
            </td>
            <td width="90px">
                <button class="btn btn-warning"> 미응시</button>

            </td>
            <td width="90px">
                <button class="btn btn-warning"> 미제출</button>

            </td>
        </tr>

        </tbody>

    </table>
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
                    <tbody id="student_grade_list">

                    </tbody>
                </table>
            </div>

            <script>

                var grade1 = ["김똘똘",95,32,30,33,"19/20","pass","pass"];
                var grade2 = ["최천재",75,20,28,27,"15/20","pass","pass"];
                var grade3 = ["심사쵸",55,15,14,15,"11/20","retest_yet","submit_yet"];
                var grade4 = ["안예민",55,15,14,15,"11/20","retest_done","submit_yet"];
                var grade5 = ["사라다",55,15,14,15,"11/20","retest_done","submit_done"];

                var all_grade = [grade1,grade2,grade3,grade4,grade5];

                for(var i = 0 ; i < all_grade.length ; i++){
                    $('#student_grade_list').append($('<tr id="grade_'+all_grade[i][0]+'">'));

                    for(var j = 0 ; j < all_grade[0].length ; j++ ) {

                        if( j >= 6){
                            if (all_grade[i][j] != "pass"){
                                $('#grade_' + all_grade[i][0]).append($('<td>').append($('<a href="#">').text(all_grade[i][j])));
                            }else{
                                $('#grade_' + all_grade[i][0]).append($('<td>').text(all_grade[i][j]));
                            }
                        }else{
                            $('#grade_' + all_grade[i][0]).append($('<td>').text(all_grade[i][j]));
                        }
                    }
                }

            </script>

                <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">학생 점수 인쇄</button>
            </div>
        </div>

        {{--상세 보기--}}
        <div class="modal-content" style="margin-top: 10px;padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">상세 보기</h3>
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

                    <style>
                        .table-striped {
                            border: 1px solid #e5e6e8;
                        }
                        .table-striped thead tr> :first-child{
                            width: 130px;
                            text-align: center;
                        }
                        .table-striped tbody tr td {
                            width: 70px;
                            border: 1px solid #e5e6e8;
                        }
                    </style>

                    <table class="table table-striped">
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
                        var grade2 = ["o","o","x","x","o","o","o","o","o","x","o","o","o","x","o","o","x","o","x","o"];
                        var grade3 = ["o","o","x","o","x","x","o","o","x","o","x","o","x","o","o","o","x","o","x","x"];
                        var grade4 = ["o","o","x","o","x","x","o","o","x","o","x","o","x","o","o","o","x","o","x","x"];
                        var grade5 = ["o","o","x","o","x","x","o","o","x","o","x","o","x","o","o","o","x","o","x","x"];

                        for(var i = 1; i <= 20 ; i++){
                                $("#race_detail_record").append($("<th>").text(i));
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

                    <div style="margin: 0px;">오답 문제( 3개 )</div>

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
                                <td rowspan="1" colspan="2" style="text-align: center;">
                                    苦労してためたお金なのだから、一円（　　）無駄には使いたくない。
                                </td>
                                <td rowspan="3" style="border-left: 1px solid transparent;">
                                    0/5
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    たりとも
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    <div style="float:left;">
                                    ばかりも
                                    </div>
                                    <div style="float:right;">
                                        2명
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="float:left;">
                                        だけさえ
                                    </div>
                                    <div style="float:right;">
                                        2명
                                    </div>
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    <div style="float:left;">
                                        とはいえ
                                    </div>
                                    <div style="float:right;">
                                        1명
                                    </div>
                                </td>
                            </tr>
                        </div>
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    13
                                </td>
                                <td rowspan="1" colspan="2" style="text-align: center;">
                                    この店は洋食と和食の両方が楽しめる（　　）、お得意さんが多い。
                                </td>
                                <td >
                                    2/5
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    とあって
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    からして
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    にあって
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    <div style="float:left;">
                                        にしては
                                    </div>
                                    <div style="float:right;">
                                        3명
                                    </div>
                                </td>
                            </tr>
                        </div>
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    17
                                </td>
                                <td rowspan="1" colspan="2" style="text-align: center;">
                                    姉は市役所に勤める（　　）、ボランティアで日本語を教えています。
                                </td>
                                <td>
                                    1/5
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    かたわら
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    かたがた
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="float:left;">
                                        こととて
                                    </div>
                                    <div style="float:right;">
                                        3명
                                    </div>
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    <div style="float:left;">
                                        うちに
                                    </div>
                                    <div style="float:right;">
                                        1명
                                    </div>
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