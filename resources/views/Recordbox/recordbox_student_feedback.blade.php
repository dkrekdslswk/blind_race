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

<script>

    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('output');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };

</script>


<div class="feedback_page" style="margin: 10px;">
    <table class="table table-bordered table-list" style="margin: 0;">
        <thead>
        <tr>
            <td>
                작성일자
            </td>
            <td>
                제목
            </td>
            <td id="feedbackCheck" name="feedback_check">
                상태
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>18.04.17</td>
            <td>
                <a href="#" data-toggle="modal" data-target="#Modal2">
                    [스쿠스쿠레이스2 - 3번] 질문있습니다.
                </a>
            </td>
            <td  id="feedbackCheckIcon" name="feedback_check" style="text-align: center">
                <button type="button" id="1check" class="btn btn-warning" data-toggle="modal" data-target="#Modal2">미확인</button>
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

<button class="btn btn-default" data-toggle="modal" data-target="#Modal_question">글쓰기</button>
