<!DOCTYPE html>

<html>
    <head>
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
        <link href="css/homemain.css" rel="stylesheet" type="text/css" media="all">

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

                        <button  onclick="document.getElementById('id01').style.display='block'" class="mainbtn">Login</button> 
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
                                <em>My group</em>
                            </a>
                        </li>
                    
                    <li>
                            <a class="mt-green" href="{{ url('race_list') }}">
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
           
            <div class="wrapper row3">
                <div class="lrspace">
                    <main class="container clear">
                        <!-- main body -->
                       
                        <figure class="group">
                            <div class="one_half first"><img src="https://i.imgur.com/YfSCTE0.png" alt=""></div>
                            <figcaption class="one_half">
                                <h1 class="xxl">十分十分
                                </h1>
                                <h1 class="xxl">
                                    Free download Now!</h1>
                                <p></p>

                            </figcaption>
                        </figure>

                        <!--
                        ################################################################################################
                        -->
                        <!-- / main body -->
                        <div class="clear"></div>
                    </main>
                </div>
            </div>

            <!-- <div
                class="wrapper "
                style="background-image:url('https://i.imgur.com/TblNDot.png');">
                <div>
                    <div id="cta" class="clear center">
                        <!--
                        ################################################################################################
                        -->
                        <!-- <h2 class="heading"></h2>
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                      
                    </div>
                </div>
            </div> --> -->

           

        </div>
    </div>
</div>
<!--

<div
    class="wrapper row4 bgded"
    style="background-image:url('images/demo/backgrounds/02.png');">
    <div class="lrspace overlay">
        <footer id="footer" class="clear">
            <!--
            ################################################################################################
            -->

            <!--
            ################################################################################################
            -->
        </footer>
    </div>
</div>
<!--
################################################################################################
-->
<!--
################################################################################################
-->
<!--
################################################################################################
-->
<div class="wrapper row5">
    <div class="lrspace">
        <div id="copyright" class="clear">
            <!--
            ################################################################################################
            -->
            <p class="fl_left">Copyright &copy; 2018 - WDJ 7조 -
                <a href="#">캡스톤 디자인</a>
            </p>
            <p class="fl_right">Template by
                <a
                    target="_blank"
                    href="http://www.os-templates.com/"
                    title="Free Website Templates">WDJ7조</a>
            </p>
            <!--
            ################################################################################################
            -->
        </div>
    </div>
</div>
<!--
################################################################################################
-->
<!--
################################################################################################
-->
<!--
################################################################################################
-->
<a id="backtotop" href="#top">
    <i class="fa fa-chevron-up"></i>
</a>



<div id="id01" class="modal">

    <form class="modal-content animate" action="/action_page.php">
        <div class="imgcontainer">
            <span
                onclick="document.getElementById('id01').style.display='none'"
                class="close"
                title="Close Modal">&times;</span>
            <!-- <img src="https://i.imgur.com/pDvUuvf.png" alt="Avatar2" class="avatar" width ="200px"> -->
        </div>

        <div class="container">
            <label for="uname">
                <b>학번</b>
            </label>
            <input
                type="text"
                placeholder="학번 입력"
                name="uname"
                required="required">

            <label for="psw">
                <b>Password</b>
            </label>
            <input
                type="password"
                placeholder="Enter Password"
                name="psw"
                required="required">
           
            <button type="submit" style ="color : black">Login</button>
           


        </div>

   
    
    </form>
</div>

<div id="id02" class="modal">
  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
  <form class="modal-content" action="/action_page.php">
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
<script src="js/jquery.min.js"></script>
<script src="js/mi.js"></script>
<script src="js/jquery.backtotop.js"></script>
<script src="js/jquery.mobilemenu.js"></script>

<script>
  
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
</script
</script>

</body>

</html>