<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyGroup</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">
</head>
<style>
    .barStyle {
        width: 100%;
        height: 120px;
        background-color: #002266;
    }
</style>
<script>
    var json = '{"users":[{"userName":"tester1","userScore":9}, ' +
                '{"userName":"tester2","userScore":10},' +
                '{"userName":"tester3","userScore":35}]}';

    var getJsonDate = JSON.parse(json);

    var test = document.getElementById("test");
    test.innerHTML("test");

/*    for(var i = 0 ; i < getJsonDate.users.length ; i++){
        alert(i+"번 유저 이름:" + getJsonDate.users[i].userName + ", 점수:" +  getJsonDate.users[i].userScore);
    }*/
</script>
<body>
<nav>
    @include('Navigation.mainnav')
</nav>

<div style="height: 10px"></div> {{--여백--}}
<div style="width: 100%; height: 130px;">
    <div style="width: 130px; height: 100%; text-align: center; float: left">
        <img src="img/networking.png" style="width: 100px; height: 100px; margin: 15px 0">
    </div>
    <div style="width: 200px; height: auto; text-align: center; float: left; margin: 40px 0">
        <font size="15" style="font-family: a옛날사진관3">나의 그룹</font>
    </div>
    <div></div> {{--메세지 버튼용--}}
    <div></div> {{--그룹 만들기 버튼용--}}
</div>

<div style="height: 50px"></div> {{--여백--}}

<div style="width: 90%; height: 650px; margin: 0 auto">
    <div style="width: 30%; height: 100%; float: left">
        <div style="width: 100%; height: 15%;">
            <img src="img/apple.png" style="height: 100%; width: auto;float: left">
            <font size="15" style="font-family: a옛날사진관3; float: left; margin: 20px 0">2학년 A반</font>
        </div>
        <div style="height: 15px"></div> {{--여백--}}
        <div style="width: 100%; height: 80%; border: 1px solid purple; overflow-y: scroll" id="test"></div>
    </div>
    <div style="width: 4.8%; height: 650px; float: left"></div>
    <div style="width: 30%; height: 100%; float: left">
        <div style="width: 100%; height: 15%; border: 1px solid green"></div>
        <div style="height: 15px"></div> {{--여백--}}
        <div style="width: 100%; height: 80%; border: 1px solid purple; overflow-y: scroll"></div>
    </div>
    <div style="width: 4.8%; height: 650px; float: left"></div>
    <div style="width: 30%; height: 100%; float: left">
        <div style="width: 100%; height: 15%; border: 1px solid green"></div>
        <div style="height: 15px"></div> {{--여백--}}
        <div style="width: 100%; height: 80%; border: 1px solid purple; overflow-y: scroll"></div>
    </div>
</div>



</body>
</html>