<style type="text/css">
  .nav-icon{
    width:20px;
    height:20px;
  }
</style>
<div>
  <!-- 상단 Navigation ( 아직 로그인부분및 링크작업은 되지않았음) -->


  <!-- 안준휘 - 상단 Navigation ( 아직 로그인부분및 링크작업은 되지않았음) -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark " id="mainNav" style="margin:0px;">
    <a class="navbar-brand" href="/">
      <!--<img src="img/logo.png" width="100" height="40" alt="">-->
      十分十分
    </a>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="#">
            <span class="nav-link-text"><img class="nav-icon " src="{{ URL::to('/img/'.'networking.png') }}"></img>  나의그룹</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="{{ url('/raceController/RaceDataGet/null') }}">
            <span class="nav-link-text"><img class="nav-icon " src="{{ URL::to('/img/'.'race.png') }}"></img>  레이스</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="#">
            <span class="nav-link-text"><img class="nav-icon " src="{{ URL::to('/img/'.'sword.png') }}"></img>  레이드</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link" href="{{ url('quizTreeController/folderRaceDataGet/null') }}" >
            <span class="nav-link-text"><img class="nav-icon " src="{{ URL::to('/img/'.'tree.png') }}"></img>  문제나무</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link" href="/recordbox">
            <span class="nav-link-text"><img class="nav-icon " src="{{ URL::to('/img/'.'bars-chart.png') }}"></img>  레코드박스</span>
          </a>
        </li>
      </ul>

    </div>
  </nav>
</div>