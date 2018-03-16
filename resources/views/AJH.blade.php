<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
         <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
         
    <style type="text/css">
        .content{
            height:80px;
        }
        table {
          border-spacing: 1;
          border-collapse: collapse;
          background: white;
          border-radius: 6px;
          overflow: hidden;
          max-width: 800px;
          width: 100%;
          margin: 0 auto;
          position: relative;
        }
        table * {
          position: relative;
        }
        table td, table th {
          padding-left: 8px;
            vertical-align:middle;
        }
        table thead tr {
          height: 60px;
          background: navy;
          color:white;
          font-size: 16px;
        }
        table tbody tr {
          height: 48px;
          border-bottom: 1px solid #E3F1D5;
        }
        table tbody tr:last-child {
          border: 0;
        }
        table td, table th {
          text-align: center;
         
        }
         .tb{
         }
         li{
             background-color:white;
         }
    </style>

</head>
<body>
    <div class="tb" >
    <nav class="col-sm-3  sidebar table-responsive">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">레이스 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
             <div class="col-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="1000" height="1000" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <div class="text-muted">Something else</div>
            </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Analytics</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Export</a>
            </li>
          </ul>
        </div>
        
        
     <div class="tb">
               <table class="" >
            <thead>
            <tr>
                <th>Name</th>
                <th>Level</th>
                <th>page</th>
                <th></th>
            </tr>
            </thead>
            <tr class="content">
                <td>스쿠스쿠레이스1</td>
                <td>Level</td>
                <td>p15 - p30</td>
                <td><button class="btn btn-info">시작하기</button></td>
            </tr>
            <tr class="content">
                <td>스쿠스쿠레이스2</td>
                <td>Level</td>
                <td>p30 - p45</td>
                <td><button class="btn btn-info">시작하기</button></td>
            </tr>
            <tr class="content">
                <td>스쿠스쿠레이스3</td>
                <td>Level</td>
                <td>p45 - p60</td>
                <td><button class="btn btn-info">시작하기</button></td>
            </tr>
        </table>
     </div>
    
    
    <!--<div>-->
    <!--    <table class="" >-->
    <!--        <thead>-->
    <!--        <tr>-->
    <!--            <th>Name</th>-->
    <!--            <th>Level</th>-->
    <!--            <th>page</th>-->
    <!--            <th></th>-->
    <!--        </tr>-->
    <!--        </thead>-->
    <!--        <tr class="content">-->
    <!--            <td>스쿠스쿠레이스1</td>-->
    <!--            <td>Level</td>-->
    <!--            <td>p15 - p30</td>-->
    <!--            <td><button class="btn btn-info">시작하기</button></td>-->
    <!--        </tr>-->
    <!--        <tr class="content">-->
    <!--            <td>스쿠스쿠레이스2</td>-->
    <!--            <td>Level</td>-->
    <!--            <td>p30 - p45</td>-->
    <!--            <td><button class="btn btn-info">시작하기</button></td>-->
    <!--        </tr>-->
    <!--        <tr class="content">-->
    <!--            <td>스쿠스쿠레이스3</td>-->
    <!--            <td>Level</td>-->
    <!--            <td>p45 - p60</td>-->
    <!--            <td><button class="btn btn-info">시작하기</button></td>-->
    <!--        </tr>-->
    <!--    </table>-->
    <!--</div>-->
    웰컴 안준휘작업파일 


    <!--<div id="app"></div>-->
      <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
