<?php
/**
 * Created by PhpStorm.
 * User: kimseungmok
 * Date: 2018-03-28
 * Time: 오후 8:02
 *
 * 레이스 기본 네비게이션
 */
?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Waiting Room</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

</head>
<body>

{{--레이스 네비게이션--}}
<racenav>
    @include('Navigation.racenav');
</racenav>



</body>
</html>