<style>
    .recordbox_navbar {
        margin: 0;
        padding: 0;
        height: 50px;
        min-width: 700px;
        width: 100%;
        transition: top 0.2s ease-in-out;
        position: relative;
        display: block;
        z-index: 1;
    }
    .nav-up {
        margin: 0;
        padding: 0;
        top: 0;
        left: 15%;
        height: 50px;
        width: 88%;
        position: fixed;
        z-index: 2;
    }
    .recordbox.navbar.navbar-default {
        background: #fff;
        border: 1px solid #e5e6e8;
        margin: 0;
    }
    .container-fluid {
        height: 50px;
        width: 100%;
    }
    .recordnav_once {
        margin-left: 5px;
        margin-right: 5px;
    }
    .targetMenu{
        padding: 15px 10px 9px 10px !important;
        border-bottom: 8px solid #0E76A8;
        pointer-events: none;
    }

</style>
<script>

    var reqGroupId = "{{$groupId}}";
    var Here = "{{$where}}";

    //record_recordnav.blade.php 로드시 실행될 기능들
    $(document).ready(function () {

        //디자인 추가하기
        //해당 페이지 메뉴 클릭 금지 + 해당 페이지 메뉴 밑에 바 추가하기 ( addClass -> targetMenu )
        $('.recordbox #'+Here).addClass('targetMenu');


        //메뉴 클릭시 ULR로 페이지 이동
        $(document).on('click','.recordnav_once',function () {

            // URL : /recordbox/where/groupId
            window.location.href = "{{url('recordbox')}}/" + $(this).attr('id') + "/" + reqGroupId;
        });
    });

</script>


<nav class="recordbox navbar navbar-default">
    <div class="container-fluid" >
        <div class="navbar-header">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <ul class="nav navbar-nav nav-toggle ">
            <li>
                <a id="chart" href="#" class="recordnav_once">통계</a>
            </li>
            <li>
                <a id="history" href="#" class="recordnav_once">최근 기록</a>
            </li>
            <li>
                <a id="students" href="#" class="recordnav_once">학생 관리</a>
            </li>
            <li>
                <a id="feedback" href="#" class="recordnav_once">피드백</a>
            </li>
        </ul>
    </div>
</nav>

