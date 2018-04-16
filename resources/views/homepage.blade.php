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
        <!--
        ################################################################################################
        -->
        <!--
        ################################################################################################
        -->
        <!--
        ################################################################################################
        -->
        <div class="wrapper row1">
            <header id="header" class="clear">
                <!--
                ################################################################################################
                -->
                <div id="logo" class="fl_left">
                    <h1>
                        <a href="index.html">
                            <em>十</em>分<em>十</em>分</a>
                    </h1>
                </div>
                <nav id="mainav" class="fl_right">
                    <ul class="clear">
                        <li class="active">
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a href="/mygroup">나의 그룹</a>
                        </li>
                        <li>
                            <a href="{{ url('quizTreeController/folderRaceDataGet/null') }}">문제 나무</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">퀴즈 시작
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ url('/raceController/RaceDataGet/null') }}">블라인드 레이스</a>
                                </li>
                                <li>
                                    <a href="#">도전 골든벨</a>
                                </li>
                                <li>
                                    <a href="/raid">레이드</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="/recordbox">레코드박스
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/recordbox">레코드 박스</a>
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
                            <a href="/login">Login</a>
                        </li>
                        <ul></ul>
                    </nav>
                    <!--
                    ################################################################################################
                    -->
                </header>
            </div>
            <!--
            ################################################################################################
            -->

            <div class="wrapper row2">
                <div id="pageintro" class="clear">
                    <!--
                    ################################################################################################
                    -->
                    <ul class="nospace group">
                        <li>
                            <a class="mt-green" href="{{ url('/raceController/RaceDataGet/null') }}">
                                <i class="fa fa-5x fa-gamepad"></i>
                                <em>Race</em>
                            </a>
                        </li>
                        <li>
                            <a class="mt-orange" href="/raid">
                                <i class="fa fa-5x fa-trophy"></i>
                                <em>Raid</em>
                            </a>
                        </li>
                        <li>
                            <a class="mt-purple" href="/mygroup">
                                <i class="fa fa-5x fa-child"></i>
                                <em>My group</em>
                            </a>
                        </li>
                        <li>
                            <a class="mt-red" href="/recordbox">
                                <i class="fa fa-5x fa-box-open"></i>
                                <em>Record Box</em>
                            </a>
                        </li>
                        <li>
                            <a class="mt-yellow" href="{{ url('quizTreeController/folderRaceDataGet/null') }}">
                                <i class="fa fa-5x fa-tree"></i>
                                <em>Quiz Tree</em>
                            </a>
                        </li>
                    </ul>
                    <!--
                    ################################################################################################
                    -->
                </div>
            </div>
            <!--
            ################################################################################################
            -->

            <div class="wrapper row3">
                <div class="lrspace">
                    <main class="container clear">
                        <!-- main body -->
                        <!--
                        ################################################################################################
                        -->
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

            <div
                class="wrapper "
                style="background-image:url('https://i.imgur.com/TblNDot.png');">
                <div>
                    <div id="cta" class="clear center">
                        <!--
                        ################################################################################################
                        -->
                        <h2 class="heading"></h2>
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <!--
                        ################################################################################################
                        -->
                    </div>
                </div>
            </div>

  
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
<!-- JAVASCRIPTS -->
<script src="js/jquery.min.js"></script>
<script src="js/mi.js"></script>
<script src="js/jquery.backtotop.js"></script>
<script src="js/jquery.mobilemenu.js"></script>

<script>
    $(function () {
        $("body div").fadeIn(500, function () {
            $(this).animate({
                "top": "30px"
            }, 1000);
        });

        $("a").click(function () {
            var url = $(this).attr("href");
            $("body div").animate({
                "opacity": "0",
                "top": "10px"
            }, 500, function () {
                document.location.href = url;
            });

            return false;
        });
    });
</script>
</body>

</html>