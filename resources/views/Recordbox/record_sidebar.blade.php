
<style>
    .recordbox_sidebar {
        margin: 0;
        padding: 0;
        position: relative;
        width: 15%;
        height:100%;
        float: left;
        border: 1px solid #e5e6e8;
    }
    .sidenav-up {
        margin: 0;
        padding: 0;
        top: 0;
        left: 0;
        width: 15%;
        position: fixed;
        z-index: 2;
    }
    .page-small {
        display: none !important;
    }
    .page-small {
        width: 100% !important;
    }
    .m-t-lg {
        margin-top: 30px !important;
    }
    .main-left-menu {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    #side-menu li .nav-second-level li a, #side-menu2 li .nav-second-level li a, #side-menu2 li .nav-second-level a {
        padding: 8px 10px 8px 20px;
        color: #5f5f5f;
        text-transform: none;
        font-weight: normal;
        position: relative;
        display: block;
        font-size: 14px;
    }
    .class_list a:hover{
        background-color:#d9edf7;
    }
    .checking-class_list{
        background-color:#d9edf7;
    }

    @media (max-width: 768px) {
        .page-small .content, .page-small #wrapper-class .content, .page-small .content-main {
            padding: 15px 5px;
            min-width: 320px
        }
    }
</style>
<script>

    //보여줄 클래스아이디
    var reqGroupId = "{{$groupId}}";


    //sidebar에서 실행할 메소드들
    $(document).ready(function () {

        //클래스 리스트 불러오기
        loadClasses();

        //사이드바 클래스이름 클릭했을 경우
        $(document).on('click','.groups',function () {

            //요구하는 클래스를 URL에 집어넣어 이동하기
            var groupId = $(this).attr('id');
            window.location.href = "{{url('recordbox/'.$where)}}/" + groupId;
        });
    });


    //해당하는 교수님의 클래스 목록 불러오기
    //URL에서 조회하려는 클래스가 없을 경우 -> alert("없는 페이지입니다.");
    function loadClasses() {
        var nonCount = 0;

        //클래스 불러오기 and 차트 로드하기 and 학생 명단 출력하기 and 피드백 가져오기
        $.ajax({
            type: 'POST',
            url: "{{url('/groupController/groupsGet')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: null,
            success: function (data) {

                var GroupData = data.groups;

                //사이드바에 클래스 추가
                for( var i = 0 ; i < GroupData.length ; i++ ){

                    $('.class-toggle').append($('<div>').attr('class','nav-second-level class_list')
                        .append($('<a href="#">')
                            .attr('class','groups')
                            .attr('name',GroupData[i]['groupName'])
                            .attr('id',GroupData[i]['groupId'])
                            .text(GroupData[i]['groupName'])));

                    //찾고자 하는 클래스가 없을 경우 -> nonCount + 1
                    if (GroupData[i]['groupId'] != reqGroupId){ nonCount++ }
                    else{
                        //있으면 색깔 넣어주기
                        $('.class-toggle #'+reqGroupId).addClass('checking-class_list');
                    }
                }
                //조회하려는 클래스가 없을 경우 -> (nonCount == GroupData.length)
                if(nonCount == GroupData.length){

                    //체인지페이지 부분 안보이게 하기
                    $('.changePages').hide();
                    alert("없는 클래스입니다.");

                }else{

                    //체인지페이지 부분 보이게 하기
                    $('.changePages').show();

                    //레코드박스 네비바 첫부분에 상단 클래스 이름 넣기
                    $('.navbar .navbar-header').attr('class','navbar-brand').text($('.class-toggle #'+reqGroupId).attr('name'));

                }
            },
            error: function (data) {
                alert("로그인부터 해주시기 바랍니다.");
            }
        });
    }


    //스크롤하면 fixed로 변경하기
    $(window).scroll(function (event) {

        if($(window).scrollTop() == 0){
            $('.recordbox_navbar').removeClass('nav-up');
            $('.recordbox_navbar').removeClass('nav-up');
        }else {
            $('.recordbox_navbar').addClass('nav-up');
        }
    });

</script>

<div class="recordbox_sidebar" >

    <div class="innerContents">
        <!--네비바 위부분 공백-->
        <div class="page-small" style="text-align: center; margin-top: 10px; margin-bottom:10px;">
        </div>

        <div class="m-t-lg">
            <ul class="main-left-menu" id="side-menu2">

                {{--그룹 파트--}}
                <li class="" id="side-menu3_li" style=" margin-top: 20px;margin-left: 10px;">
                    나의 클래스
                </li>

                {{--클래스 이름 리스트 들어갈 자리--}}
                <li class="class-toggle">

                </li>
            </ul>
        </div>
    </div>
</div>
