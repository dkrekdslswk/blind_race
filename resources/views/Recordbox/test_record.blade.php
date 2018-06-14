{{--Modal : select group--}}
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >

            <div class="modal-header">
                <h4 class="modal-title" id="ModalLabel">피드백</h4>
                <br>
                <div class="request_date" style=";float: right;">
                    질문 날짜 : 2018-04-17
                </div>
                <br>
                <div class="response_date" style="float: right;">
                    대답한 날짜 : 2018-04-17
                </div>
                <br>
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
                    <input type="file" accept="image/*" onchange="loadFile()" id="ex_file">

                    <img id="output" style="max-width: 300px;max-height: 300px;"/>

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
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="changeCheck()" id="feedback_modal_confirm">확인</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modal_feedback_cancel">취소</button>
                </div>

                <script>
                    function changeCheck(){
                        alert('정상 등록하였습니다.');
                        $(this).attr('class','btn btn-primary').text('확인');
                    }
                </script>

            </div>
        </div>
    </div>
</div>