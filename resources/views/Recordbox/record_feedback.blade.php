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
    <table class="table table-bordered table-list">
        <thead>
        <tr>
            <td>
                작성일자
            </td>
            <td>
                제목
            </td>
            <td>
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
            <td style="text-align: center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal2">미확인</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>


{{--Modal : select group--}}
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >

            <div class="modal-header">
                <h4 class="modal-title" id="ModalLabel">피드백</h4>
                <br><br>
                <div class="request_date" style="float: right;">
                    날짜 : 2018-04-17
                </div>
            </div>

            <div class="modal-body" style="margin: 0; padding:0;">

                    <div class="request_contents" style="padding: 5px 10px 5px 10px;min-height: 150px;width: 100%;border-bottom: 1px solid #e5e6e8;">
                        오늘 푼 스쿠스쿠 퀴즈 3번 문제 답이<br>
                        왜 1번인지 이해가 안갑니다.<br>
                        4번이 해석에 더 맞지 않을까요? <br>
                    </div>

                <style>
                    .images label {
                        display: inline-block;
                        padding: .5em .75em;
                        color: #999;
                        font-size: inherit;
                        line-height: normal;
                        vertical-align: middle;
                        background-color: #fdfdfd;
                        cursor: pointer;
                        border: 1px solid #ebebeb;
                        border-bottom-color: #e2e2e2;
                        border-radius: .25em;
                    }

                    .images input[type="file"] {
                        /* 파일 필드 숨기기 */ position: absolute;
                        width: 1px;
                        height: 1px;
                        padding: 0;
                        margin: -1px;
                        overflow: hidden;
                        clip:rect(0,0,0,0);
                        border: 0;
                    }
                </style>

                    {{--사진 불러오기--}}
                    <div class="images" style="margin: 10px;">

                            <label for="ex_file">
                                파일 첨부
                            </label>
                            <input type="file" accept="image/*" onchange="loadFile(event)" id="ex_file">

                        <img id="output" style="max-width: 400px;max-height: 400px;"/>

                        {{--사진 불러오는 스크립트--}}
                        <script type="text/javascript">
                            $(document).on('click', '#modal_feedback_cancel', function (e) {
                                $('#output').attr("src","");
                                $('#teachersFeedback').val("");
                            });
                        </script>
                    </div>

                        {{--텍스트 창--}}
                    <div class="answer" style="padding: 5px 5px 5px 5px">
                        <input type="text" id="teachersFeedback" name="contents" style="width: 100%;height:120px;"></input>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="feedback_modal_confirm">확인</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modal_feedback_cancel">취소</button>
                </div>

            </div>
        </div>
    </div>
</div>
