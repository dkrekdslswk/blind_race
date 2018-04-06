<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>Login & Sign Up Form Concept</title>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel="stylesheet" href="css/signstyle.css">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

</head>

<body>

<div id="app" >
</div>


<script src="{{asset('js/app.js')}}"></script>


<div class="cotn_principal">
    <div class="cont_centrar">

        <div class="cont_login">
            <div class="cont_info_log_sign_up">
                <div class="col_md_login">
                    <div class="cont_ba_opcitiy">

                        <h2>LOGIN</h2>
                        <p>기존의 쥿뿐쥬-분 회원이시면 <br> 로그인해주세요^^</p>
                        <button class="btn_login" onclick="cambiar_login()">LOGIN</button>
                        
                    </div>
                </div>
                <div class="col_md_sign_up">
                    <div class="cont_ba_opcitiy">
                        <h2>SIGN UP</h2>


                        <p>아직도 회원이 아니신가요? <br> 회원가입 해주세요^^</p>

                        <button class="btn_sign_up" onclick="cambiar_sign_up()">SIGN UP</button>
                    </div>
                </div>
            </div>


            <div class="cont_back_info">
                <div class="cont_img_back_grey">
                    {{--<img src="https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?ixlib=rb-0.3.5&q=50&fm=jpg&crop=entropy&s=7686972873678f32efaf2cd79671673d" alt="" />--}}
                    <img src="background/japan.jpg" alt="">
                </div>
            </div>
            <div class="cont_forms" >
                <div class="cont_img_back_">
                    {{--<img src="https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?ixlib=rb-0.3.5&q=50&fm=jpg&crop=entropy&s=7686972873678f32efaf2cd79671673d" alt="" />--}}
                    <img src="background/japan.jpg" alt="">                
                </div>
                <div class="cont_form_login">
                    <form action="{{URL::to('/미구현')}}" method="post">

                    <a href="#" onclick="ocultar_login_sign_up()" ><i class="material-icons">&#xE5C4;</i></a>
                    <h2>LOGIN</h2>
                    <input type="text" name="ID" placeholder="Email" />
                    <input type="password" name="PW" placeholder="Password" />

                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                    <button class="btn_login" onclick="cambiar_login()">LOGIN</button>
                        <div> <a href="/homepage"> <input type="submit" value="Login"></a></div>

                    </form>
                </div>

                <div class="cont_form_sign_up">
                    <form action="{{URL::to('/store')}}" method="post">

                        <a href="#" onclick="ocultar_login_sign_up()"><i class="material-icons">&#xE5C4;</i></a>
                    <h2>SIGN UP</h2>
                    <input type="text" name="user_name" placeholder="user name" />
                    <input type="text" name="ID" placeholder="your ID" />
                    <input type="password" name="PW" placeholder="your Password" />
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button class="btn_sign_up" onclick="cambiar_sign_up()">SIGN UP</button>
                    <div> <a href="/homepage"> <input type="submit" value="Login"></a></div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<script  src="js/sign.js"></script>
</body>
</html>
