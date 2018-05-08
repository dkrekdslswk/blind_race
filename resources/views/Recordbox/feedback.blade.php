<style type="text/css">
    .feedbackBar {
        margin-right: 13%;
        margin-bottom: 20px;
        text-align: right;
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

<div class="feedback_page">
    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">질문 현황</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th style="text-align:center">작성일자</th>
                            <th style="text-align: center">제목</th>
                            <th style="text-align: center">상태</th>
                        </tr>
                        </thead>
                        <tbody id="list">

                        <tr>
                            <td>18.04.17</td>
                            <td>
                                [스쿠스쿠레이스2 - 3번] 질문있습니다.
                            </td>
                            <td style="text-align: center">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal2">확인하기</button>
                            </td>
                        </tr>
                        <tr>
                            <td>18.04.17</td>
                            <td>[스쿠스쿠레이스1 -2번] 질문있습니다. </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal2">답변완료</button>
                            </td>
                        </tr>
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
    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">피드백</h5>
                </div>

                <div style="margin-left: 10px;">
                    오늘 푼 스쿠스쿠 퀴즈 3번 문제 답이<br>
                    왜 1번인지 이해가 안갑니다.<br>
                    4번이 해석에 더 맞지 않을까요? <br>
                </div>
                <hr>
                <div style="margin-left: 10px;">답변</div>
                <textarea rows="5" cols="80" name="contents" style="resize: none;margin-left: 10px;"></textarea>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">확인</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </div>
    </div>
</div>

</html>
