<!DOCTYPE html>

<html>
    <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <script
            defer="defer"
            src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"
            integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
            crossorigin="anonymous"></script>
        <title>YourChoice</title>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link href="{{url('css/homemain.css')}}" rel="stylesheet" type="text/css" media="all">
      
    </head>
    <body
        id="top"
        class="bgded fixed"
        style="background-image:url('https://i.imgur.com/BMhEarm.jpg');">

        <div class="wrapper row1">
            <header id="header" class="clear">
             
                <div id="logo" class="fl_left">
                    <h1>
                        <a href="#">
                            <em>十</em>分<em>十</em>分</a>
                    </h1>
                </div>
                <nav id="mainav" class="fl_right">
                    <ul class="clear">
                        <li class="active">
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="{{ url('mygroup') }}">나의 그룹</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('race_list') }}">레이스
                         
                        </li>
                       

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('recirdbox') }}">레코드박스
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ url('recirdbox') }}">레코드 박스</a>
                                </li>
                                <li>
                                    <a href="#">오답노트</a>
                                </li>
                                <li>
                                    <a href="/Feedback">피드백</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url('quiz_list') }}">문제 나무</a>
                        </li>
                        <li>

                        <button  onclick="document.getElementById('id01').style.display='block'" class="mainbtn"><?php if(isset($response['check'] )){echo "logout"; } else { echo "login" ;}; ?>  </button> 
                        </li>
                        <li>
                       
                        <button onclick="document.getElementById('id02').style.display='block'" class="mainbtn">Sign up</button>  
                        </li>
                        <ul></ul>
                    </nav>
                  
                </header>
            </div>
         

            <div class="wrapper row2">
                <div id="pageintro" class="clear">
                  
                    <ul class="nospace group">
                    <li>
                            <a class="mt-purple" href="/mygroup">
                                <i class="fa fa-5x fa-child"></i>
                                <em>My Class</em>
                            </a>
                        </li>
                    
                    <li>
                            {{--<a class="mt-green" href="{{ url('race_list') }}">--}}

                             <?php if(isset($response['classification'])){
                                  if($response['classification'] == "teacher" )
                                    echo "<a class='mt-green' href='/race_list'>";
                                  else if($response['classification'] == "student")
                                      echo "<a class='mt-green' href='/race_student'>";
                                 }else{
                                      echo "<a class='mt-green' >";
                                 } ?>

                                <i class="fa fa-5x fa-gamepad"></i>
                                <em>Race</em>
                            </a>
                        </li>
                        <li>
                            <a class="mt-red" href="/recordbox">
                                <i class="fa fa-5x fa-box-open"></i>
                                <em>Record Box</em>
                            </a>
                        </li>
                        <li>
                            <a class="mt-yellow" href="{{ url('quiz_list') }}">
                                <i class="fa fa-5x fa-tree"></i>
                                <em>Quiz Tree</em>
                            </a>
                        </li>
               
               
                        <li>
                            <a class="mt-orange" href="/raid">
                                <i class="fa fa-5x fa-comments"></i>
                                <em>Feedback</em>
                            </a>
                        </li>
                  
               
                   
                    </ul>
                   
                </div>
            </div>
           
            {{--<div class="wrapper row3">--}}
                {{--<div class="lrspace">--}}
                    {{--<main class="container clear">--}}
                        {{--<!-- main body -->--}}

                        {{--<figure class="group">--}}
                            {{--<div class="one_half first"><img src="https://i.imgur.com/YfSCTE0.png" alt=""></div>--}}
                            {{--<figcaption class="one_half">--}}
                                {{--<h1 class="xxl">十分十分--}}
                                {{--</h1>--}}
                                {{--<h1 class="xxl">--}}
                                    {{--Free download Now!</h1>--}}
                                {{--<p></p>--}}

                            {{--</figcaption>--}}
                        {{--</figure>--}}

                        {{--<!----}}
                        {{--################################################################################################--}}
                        {{---->--}}
                        {{--<!-- / main body -->--}}
                        {{--<div class="clear"></div>--}}
                    {{--</main>--}}
                {{--</div>--}}
            {{--</div>--}}



        <div class="wrapper row3">
            <div class="lrspace">


                    <!-- Team member -->
                    {{--<div class="col-xs-12 col-sm-6 col-md-4 inli">--}}
                        {{--<div class="image-flip" ontouchstart="this.classList.toggle('hover');">--}}
                            {{--<div class="mainflip">--}}
                                {{--<div class="frontside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<p><img class=" img-fluid" src="https://i.imgur.com/baXiQ1M.jpg" alt="card image"></p>--}}
                                            {{--<h4 class="card-title">to 성 형 석 길 이 맞  </h4>--}}
                                            {{--<p class="card-text">집에가고싶다.</p>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="backside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<h4 class="card-title">My class</h4>--}}
                                            {{--<p class="card-text">영어로 se..brother suck.</p>--}}
                                            {{--<ul class="list-inline">--}}

                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-6 col-md-4 inli">--}}
                        {{--<div class="image-flip" ontouchstart="this.classList.toggle('hover');">--}}
                            {{--<div class="mainflip">--}}
                                {{--<div class="frontside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<p><img class=" img-fluid" src="https://i.imgur.com/QUJ0Ak1.jpg" alt="card image"></p>--}}
                                            {{--<h4 class="card-title">to 김 승 목 길 이 맞  </h4>--}}
                                            {{--<p class="card-text">집에가고싶다.</p>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="backside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<h4 class="card-title">My class</h4>--}}
                                            {{--<p class="card-text">머리 몇시간쨰만지는중.</p>--}}
                                            {{--<ul class="list-inline">--}}

                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-6 col-md-4 inli">--}}
                        {{--<div class="image-flip" ontouchstart="this.classList.toggle('hover');">--}}
                            {{--<div class="mainflip">--}}
                                {{--<div class="frontside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<p><img class=" img-fluid" src="https://i.imgur.com/JBe6gnm.jpg" alt="card image"></p>--}}
                                            {{--<h4 class="card-title">to 최 병 찬 길 이 맞   </h4>--}}
                                            {{--<p class="card-text">?????????</p>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="backside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<h4 class="card-title">My class</h4>--}}
                                            {{--<p class="card-text">병찬이 갈리는소리골골  .</p>--}}
                                            {{--<ul class="list-inline">--}}

                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-6 col-md-4 inli">--}}
                        {{--<div class="image-flip" ontouchstart="this.classList.toggle('hover');">--}}
                            {{--<div class="mainflip">--}}
                                {{--<div class="frontside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<p><img class=" img-fluid" src="https://i.imgur.com/LlQi7HQ.jpg" alt="card image"></p>--}}
                                            {{--<h4 class="card-title">to 시 뮤 림 레 기 다</h4>--}}
                                            {{--<p class="card-text">집에가고싶다.</p>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="backside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<h4 class="card-title">My class</h4>--}}
                                            {{--<p class="card-text">마인크래프트보는초딩 ㅇㅈ?.</p>--}}
                                            {{--<ul class="list-inline">--}}

                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-6 col-md-4 inli">--}}
                        {{--<div class="image-flip" ontouchstart="this.classList.toggle('hover');">--}}
                            {{--<div class="mainflip">--}}
                                {{--<div class="frontside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<p><img class=" img-fluid" src="https://i.imgur.com/7FoPGzz.jpg" alt="card image"></p>--}}
                                            {{--<h4 class="card-title">to안준휘(김하온)</h4>--}}
                                            {{--<p class="card-text">집에가고싶다.</p>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="backside">--}}
                                    {{--<div class="card">--}}
                                        {{--<div class="card-body text-center mt-4">--}}
                                            {{--<h4 class="card-title">My class</h4>--}}
                                            {{--<p class="card-text">사랑해.</p>--}}
                                            {{--<ul class="list-inline">--}}

                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                            <!-- main body -->
                            <!-- ################################################################################################ -->
                            <div class="center btmspace-80">
                                <h3 class="heading">My Class</h3>
                                <p class="nospace">Cras dapibus ipsum vel eleifend commodo eros tortor imperdiet elit eget molestie nisi lectus.</p>
                            </div>
                            <ul class="nospace group services">
                                <li class="one_third first">
                                    <article><a href="#"><i class="fa fa-object-group"></i></a>
                                        <h6 class="heading">Race</h6>
                                        <p>영준님 대학생때 캠퍼스 잔디밭에서 그냥 방담 하는 분위기 였는데 외국인 교수와 같이 연주하는 거 봤습니다...... 그때 협연주 참 멋있었어요.. 부산 출신 친구가 음악 잘하시는 분이라고 알고 있더라고요.. 아마 고등학교 떄도 유명하셨던 듯.... 그런 기억의 길....</p>
                                        <footer><a href="#">이동하기 &raquo;</a></footer>
                                    </article>
                                </li>
                                <li class="one_third">
                                    <article><a href="#"><i class="fa fa-fighter-jet"></i></a>
                                        <h6 class="heading">Record Box</h6>
                                        <p>영준님 대학생때 캠퍼스 잔디밭에서 그냥 방담 하는 분위기 였는데 외국인 교수와 같이 연주하는 거 봤습니다...... 그때 협연주 참 멋있었어요.. 부산 출신 친구가 음악 잘하시는 분이라고 알고 있더라고요.. 아마 고등학교 떄도 유명하셨던 듯.... 그런 기억의 길....</p>
                                        <footer><a href="#">이동하기 &raquo;</a></footer>
                                    </article>
                                </li>
                                <li class="one_third">
                                    <article><a href="#"><i class="fa fa-pagelines"></i></a>
                                        <h6 class="heading">Quiz Tree</h6>
                                        <p>영준님 대학생때 캠퍼스 잔디밭에서 그냥 방담 하는 분위기 였는데 외국인 교수와 같이 연주하는 거 봤습니다...... 그때 협연주 참 멋있었어요.. 부산 출신 친구가 음악 잘하시는 분이라고 알고 있더라고요.. 아마 고등학교 떄도 유명하셨던 듯.... 그런 기억의 길....</p>
                                        <footer><a href="#">이동하기 &raquo;</a></footer>
                                    </article>
                                </li>
                                <li class="one_third first">
                                    <article><a href="#"><i class="fa fa-cubes"></i></a>
                                        <h6 class="heading">Feedback</h6>
                                        <p>영준님 대학생때 캠퍼스 잔디밭에서 그냥 방담 하는 분위기 였는데 외국인 교수와 같이 연주하는 거 봤습니다...... 그때 협연주 참 멋있었어요.. 부산 출신 친구가 음악 잘하시는 분이라고 알고 있더라고요.. 아마 고등학교 떄도 유명하셨던 듯.... 그런 기억의 길....</p>
                                        <footer><a href="#">이동하기 &raquo;</a></footer>
                                    </article>
                                </li>
                                <li class="one_third">
                                    <article><a href="#"><i class="fa fa-universal-access"></i></a>
                                        <h6 class="heading">My Class</h6>
                                        <p>영준님 대학생때 캠퍼스 잔디밭에서 그냥 방담 하는 분위기 였는데 외국인 교수와 같이 연주하는 거 봤습니다...... 그때 협연주 참 멋있었어요.. 부산 출신 친구가 음악 잘하시는 분이라고 알고 있더라고요.. 아마 고등학교 떄도 유명하셨던 듯.... 그런 기억의 길....</p>
                                        <footer><a href="#">이동하기 &raquo;</a></footer>
                                    </article>
                                </li>
                                <li class="one_third">
                                    <article><a href="#"><i class="fa fa-fort-awesome"></i></a>
                                        <h6 class="heading">Mauris proin venenatis</h6>
                                        <p>Arcu dignissim interdum quis vel est aenean hendrerit lacus non nisl iaculis sed suscipit&hellip;</p>
                                        <footer><a href="#">Read More &raquo;</a></footer>
                                    </article>
                                </li>
                            </ul>
                            <!-- ################################################################################################ -->
                            <!-- / main body -->
                            <div class="clear"></div>



                </main>
            </div>
        </div>

        </div>
    </div>
</div>



<div class="wrapper row5">
    <div class="lrspace">
        <div id="copyright" class="clear">

            <p class="fl_left">Copyright &copy; 2018 - WDJ 7조 -
                <a href="#">캡스톤 십자인대</a>
            </p>
            <p class="fl_right">Template By
                <a
                    target="_blank"
                    href="http://www.os-templates.com/"
                    title="Free Website Templates">WDJ7조</a>
            </p>
            
        </div>
    </div>
</div>

<a id="backtotop" href="#top">
    <i class="fa fa-chevron-up"></i>
</a>



<div id="id01" class="modal">
   <form class="modal-content" action="{{url('userController/webLogin')}}"  method="Post" enctype="multipart/form-data">
  
        <div class="imgcontainer">
        
            <span
                onclick="document.getElementById('id01').style.display='none'"
                class="close"
                title="Close Modal">&times;</span>
            <!-- <img src="https://i.imgur.com/pDvUuvf.png" alt="Avatar2" class="avatar" width ="200px"> -->
        </div>

        <div class="container">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
            <label for="p_ID">
                <b>학 번</b>
            </label>
            <input
                type="text"
                placeholder="학번을  입력"
                name="p_ID"
                required="required"
                value="123456789">

            <label for="p_PW">
                <b>Password</b>
            </label>
            <input
                type="password"
                placeholder="Enter Password"
                name="p_PW"
                required="required"
                value="sub"
                >
        
            <button type="submit" style ="color : black">Login</button>
           


        </div>

   
    
    </form>
</div>

<div id="id02" class="modal">
  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>


  
  <form class="modal-content" action="{{url('userController/webLogin')}}"  method="Post" enctype="multipart/form-data">
    <div class="container">
      <h1>Sign Up</h1>
      
      <hr>
      <label for="text"><b>Student ID</b></label>
      <input type="text" placeholder="Student ID" name="ID" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
      




      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </div>
  </form>
</div>


<!-- JAVASCRIPTS -->

<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/mi.js')}}"></script>
<script src="{{url('js/jquery.backtotop.js')}}"></script>
<script src="{{url('js/jquery.mobilemenu.js')}}"></script>


<script>
   
//    alert(JSON.stringify( $returnvalue));
// alert('<?php //echo $returnvalue; ?>');
    var modal = document.getElementById('id01');

    
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var modal = document.getElementById('id02');


window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>
<?php
if(isset($response))
        {echo $response['check']  ;}
if(isset($response) && $response['check']==false)
        { echo "실패"; }



?>



</body>

</html>