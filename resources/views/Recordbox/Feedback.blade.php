<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Dashboard with Off-canvas Sidebar</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		 <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
		 <link href="js/bootstrap.min.js" rel="stylesheet">
		<style type="text/css">
       

            .feedback {
                margin-left: 200px;
            }

            #curve_chart {
                margin-top: 1em;
            }

		</style>
	</head>
	<body>

    <nav>
        @include('Navigation.mainnav')
    </nav>

    <!--aside 자리-->
    <aside style="display:inline-block; vertical-align:top;">
        @include('Recordbox.Side_Bar')
    </aside>
    
  
    <div class="feedback">
        <div style="position : relative;display: block;">
  		    <button type="button" class="btn btn-primary" style="margin-left:90px;">2-특강 A반</button>
            <button type="button" class="btn btn-primary">돌아가기</button>
        </div>

        <div class="container" style="display: inline-block;margin-left: 300px;">
  <table class="table">
    <thead>
      <tr>
        <th>날짜</th>
        <th>제목</th>
        <th>답변</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>01/08</td>
        <td>궁금하다</td>
        <td>
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">답변완료</button>
        </td>
      </tr>
      <tr>
        <td>01/08</td>
        <td>질문이다</td>
          <td>
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">답변완료</button>
        </td>
        
        
    </tbody>
  </table>
</div>
    </div>
	</body>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

    
</script>
</html>

