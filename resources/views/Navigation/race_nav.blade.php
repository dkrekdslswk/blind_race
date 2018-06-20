<style>
    /*네비 배경및 위치를 잡는 css*/
    #wait_room_nav {
        background-image: url("/img/race_waiting/race_waiting_nav.png");
        width: 100%;
        height: 125px;
        border-radius: 0px 0px 70px 70px;
        font-weight: bold;
        font-size: 50px;
    }

    /*레이스제목부분 css*/
    #race_name{
        position: absolute;
        left: 33%;
        top: 2%;
        width: 33%;
        height: 90px;
        z-index:2;
        border-radius: 100px;
        background-color: #033981;
        color: white;
        background: linear-gradient(to right, #033981 , #2571b7);
        font-size: 35px;
        text-align: center;
        line-height: 70px;
    }

    /*네비 작은 타이틀*/
    .nav_info {
        width: 10%;
        height: 60px;
        background-color: #54ace2;
        border-radius: 40px;
        text-align: center;
        color: black;
        border-bottom: 6px solid #3c98c6;
        line-height: 60px;
    }
</style>
<div id="wait_room_nav" class="inline-class shadow">

    <img id="nav_img" class="inline-class" src="/img/race_student/exam.png" style="width:100px; height:100px; z-index:2;">

    <span  class="nav_info" id="group_name" style="position: absolute; width:15%; left:10%; top:4%; font-size:20px;"> groovyroom </span>
    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 24%; top: 6%; z-index: 3; " alt="">


    <img src="/img/race_waiting/left_tob.png" style="position: absolute;  left: 25%; top: 7%; z-index: 0; width: 250px; height: 10px;" alt="">
    <img src="/img/race_waiting/big_tob.png" style="position: absolute; left: 32%; top: 4%;  z-index: 3;" alt="">
    <span  class="nav_info" id="race_name">레이스 제목 </span>
    <img src="/img/race_waiting/big_tob.png" style="position: absolute; left: 64%; top: 4%;  z-index: 3;" alt="">
    <img src="/img/race_waiting/right_tob.png" style="position: absolute;  left: 64%; top: 7%; z-index: 0; width: 250px; height: 10px;" alt="">

    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 72.5%; top: 6%; z-index: 3; " alt="">
    <span  class="nav_info" id="race_count" style="position: absolute;  right:17%; top:4%; font-size:20px;" > 문제수 </span>
    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 82%; top: 6%; z-index: 3; " alt="">

    <img src="/img/race_waiting/small_tob_line.png" style="position: absolute;  left: 82%; top: 7%; z-index: 0; width: 100px; height: 10px;" alt="">

    <span  class="nav_info" id="group_student_count" style="font-size:20px; position: absolute;  right: 2%; top:4%;">학생 총 수</span>
    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 87.5%; top: 6%; z-index: 3; " alt="">
</div>

