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
       
		  #curve_chart {
            margin-top: 1em;
        }
		</style>
	</head>
	<body>
	    <nav>
        @include('nav.mainnav')
        </nav>
      <!--aside 자리-->
      <aside style="display:inline-block; vertical-align:top;">
          @include('Recordbox.Side_Bar')

      </aside>
    <!--<div id="app"></div>-->
    <!--<script src="{{asset('js/app.js')}}"></script>  -->
    
  
    
      <div style="position : fixed">
  		 <button type="button" class="btn btn-primary" style="margin-left:90px;">2-특강 A반</button>
         <button type="button" class="btn btn-primary">돌아가기</button>
    </div>
      
        <div class="container" >
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
        <td>야 경로를 모르겟따</td>
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
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }


    
</script>
</html>

