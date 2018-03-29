
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
    <!-- 김민수 작업파일입니다.-->
	    <nav>
        @include('Navigation.mainnav')
        </nav>
      <!--aside 자리-->
      <aside style="display:inline-block; vertical-align:top; margin-right:30%; ">
          @include('Recordbox.Side_Bar')
      </aside>

    <!--<div id="app"></div>-->
    <!--<script src="{{asset('js/app.js')}}"></script>  -->
    
    <div style="display:inline-block;  ">
      
  		 <button type="button" class="btn btn-primary" >2-특강 A반</button>
         <button type="button" class="btn btn-primary">돌아가기</button>
            <div style="margin-left:30px; margin-right:30px ; width :80px ; ">
       
           </div>
         <div id="curve_chart" style="width: 900px; height: 500px;"></div>
        <div class="container" >
  <table class="table" style="margin-left:100px;">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Email</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
       <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
</div>
    </div>
  
  
        
	</body>
	<script>
  var json =
  '{"users":[{"userName":"baka","userScore":9}, {"userName":"aho","userScore":10},{"userName":"damare","userScore":35}]}';
  
  var getJsonDate = JSON.parse(json);
  
  for(var i = 0 ; i < getJsonDate.users.length ; i++){
     alert(i+"번 유저 이름:" + getJsonDate.users[i].userName + ", 점수:" +  getJsonDate.users[i].userScore);
  }
  </script>
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
          ['2007
          ',  1030,      540]
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

