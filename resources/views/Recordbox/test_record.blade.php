<style>
    .recordbox_navbar {
        margin: 0;
        padding: 0;
        height: 50px;
        width: 83%;
        transition: top 0.2s ease-in-out;
        position: relative;
        float: left;
    }
    .nav-up {
        top: 0;
        left: 17%;
        position: fixed;
        z-index: 1;
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

</style>


<div class="recordbox_navbar">
    <nav class="recordbox navbar navbar-default">
        <div class="container-fluid" >
            <div class="navbar-header">
                <a class="navbar-brand" id="nav_group_name">클래스 이름</a>
            </div>
            <ul class="nav navbar-nav nav-toggle" id="race_nav">
                <li><a id="chart" href="#" onclick="recordControl(this.id)">통계</a></li>
                <li><a id="history" href="#" onclick="recordControl(this.id)">최근 기록</a></li>
                <li><a id="students" href="#" onclick="recordControl(this.id)">학생 관리</a></li>
                <li><a id="feedback" href="#" onclick="recordControl(this.id)">피드백</a></li>
            </ul>
        </div>
    </nav>
</div>

<script>

    $(window).scroll(function (event) {

        if($(window).scrollTop() == 0){
            $('.recordbox_navbar').removeClass('nav-up');
        }else {
            $('.recordbox_navbar').addClass('nav-up');
        }
    });

</script>