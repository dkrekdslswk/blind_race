<?php

$language['feedback'] = ['check' => "확인",
                         'nocheck' => "미확인",
                         'file'=>'添付ファイル',
                         'alert'=>'登録しました',
                         'questionDate' => '質問 日付',
                         'feedbackDate' => '反問 日付',
];

?>

<style type="text/css">
    .record_feedback {
        z-index: 1;
        position: relative;
        display: block;
        clear: both;
    }
    .feedbackPage_main{
        width: 100%;
        padding: 10px 0 10px 20px;
        background-color: #f9f9f9;
        height: 50px;
        position: relative;
        display: block;
        font-size: 20px;
        text-align: left;
        margin-left: 30px;
    }
    .feedbackPage_main h4{
        color: #203a8e;
        font-weight: bold;
    }

    .feedback_page table{
        background-color: white;
    }
    .feedback_page table thead tr:first-child{
        text-align: center;
        background-color: #D7D7D7;
    }
    .feedback_page table tbody tr:nth-child(2n){
        background-color: #e6eaed;
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

    $(document).ready(function () {

        loadFeedback();


        $(document).on('click','.feedbackList',function () {
            loadFeedbackModal($(this).attr('id'));

        });

        $(document).on('click','.modal-footer .btn.btn-primary',function () {
            changeCheck($('.request_date').attr('id'));
            insertQuestion();
        });


        //과제 확인하기
        $(document).on('click','.btnHomeworkCheck',function () {
            checkHomework($(this).attr('id'));

        });

    });

    function loadFeedback(){

        var reqData = {"groupId" : 1};

        $.ajax({
            type: 'POST',
            url: "{{url('/recordBoxController/selectQnAs')}}",
            //processData: false,
            //contentType: false,
            data:reqData,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {

                /*
                Data  = { QnAs : {
                                'QnAId' : 1,
                                'userName' : 김똘똘,
                                'teacherName' : 이교수,
                                'title' : 스쿠스쿠레이스 3번문제 질문입니다.
                                'question_at' : 제 생각에는 3번이 정답인데 왜 틀린건가요
                                'answer_at' : 그건 이러이러저러저러 하단다.
                                 },
                          check : false or true
                          }
                */

                var instanceData = { QnAs : {
                        0: { QnAId: 1, userName: "김똘똘", techerName: "이교수", title: "스쿠스쿠레이스 3번문제 질문입니다.",
                            question_at: "제 생각에는 3번이 정답인데 왜 틀린건가요", answer_at: "그건 이러이러저러저러 하단다.",date : "2018-05-28"
                        }
                    }
                };

                $('#modal_feedbackList').empty();

                for(var i = 0 ; i < 1;i++){

                    $('#modal_feedbackList')
                        .append($('<tr>').attr('id','qna_'+instanceData['QnAs'][i]['QnAId'])
                            .append($('<td>').text(instanceData['QnAs'][i]['date']))
                            .append($('<td>')
                                .append($('<a href="#" data-toggle="modal" data-target="#Modal2">')
                                    .attr('class','feedbackList').attr('id',instanceData['QnAs'][i]['QnAId']).text(instanceData['QnAs'][i]['title'])
                                )
                            )
                        );
                    if(instanceData['QnAs'][i]['answer_at'] == ""){
                        $('#qna_'+instanceData['QnAs'][i]['QnAId']).append($('<td>')
                            .append($('<button>').attr('id','btnQnA_'+instanceData['QnAs'][i]['QnAId']).attr('class','btn btn-warning').text("미확인")));

                    }else{
                        $('#qna_'+instanceData['QnAs'][i]['QnAId']).append($('<td>')
                            .append($('<button">').attr('class','btn btn-primary').text("확인")));
                    }
                }

            },
            error: function (data) {
                alert("loadFeedback / 피드백 받아오기 에러");
            }

        });
    }

    function loadFeedbackModal(qnaId){

        var reqData = {"QnAId" : qnaId};

        var instanceData = { QnAs : {
                0: { QnAId: 1, userName: "김똘똘", techerName: "이교수", title: "스쿠스쿠레이스 3번문제 질문입니다.",
                    question: "제 생각에는 3번이 정답인데 왜 틀린건가요", answer:"그건 이러이러저러저러 하단다",
                    question_at: "2018-05-28",answer_at : "2018-05-29"
                }
            }
        };

        $('.request_date').empty();
        $('.response_date').empty();
        $('.request_contents').empty();
        $('#teachersFeedback').empty();
        $('.modal-footer.feedback').empty();

        for(var i = 0 ; i < 1;i++){

            $('.request_date').text("질문날짜 : "+instanceData['QnAs'][i]['question_at'] +" / 응답날짜 : "+instanceData['QnAs'][i]['answer_at'])
                .attr('id',qnaId);
            $('.request_contents').text(instanceData['QnAs'][i]['question']);
            $('#teachersFeedback').val(instanceData['QnAs'][i]['answer']);

            $('.modal-footer.feedback').append($('<button data-dismiss="modal" onclick="insertQuestion()">').attr('class','btn btn-primary').text('확인'));
            $('.modal-footer.feedback').append($('<button data-dismiss="modal" >').attr('class','btn btn-secondary').text('취소'));

        }

    }

    function insertQuestion(){

        var formData = new FormData();
        var imgfiles = document.getElementsByName("feedbackImg")[0].files[0];

        formData.append('questionImg', imgfiles);

        $.ajax({
            type: 'POST',
            url: "{{url('/recordBoxController/insertQuestion')}}",
            processData: false,
            contentType: false,
            data:formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {

            },
            error: function (data) {
                alert("loadFeedback / 피드백 등록하기 에러");
            }

        });
    }


</script>

<div class="feedbackPage_main">
    <h4>
        피드백
    </h4>
</div>

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
                <td id="feedbackCheck" class="feedback_check">
                    상태
                </td>
            </tr>
            </thead>
            <tbody id="modal_feedbackList">
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
    </div>

