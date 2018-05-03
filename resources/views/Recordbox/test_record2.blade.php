{{--메인 페이지--}}
<div id="wrapper_body">

    {{--헤드라인--}}
    <div class="content title-content" style="padding-top: 20px;">

        {{--패널 헤더--}}
        <div class="panel" style="margin-bottom: 0px;">

            {{--패널 헤더 바디--}}
            <div class="panel-body" style="background-color: #d6e8ec; border-top: none; position: relative; padding: 10px;">
                <div id="mygroup_panel_name" style="margin-left: 10px;padding-top: 25px;font-size: 24px; font-weight: 600;height:80px;">
                    나의 그룹
                </div>

                {{--그래프 출력--}}
                <div style="text-align: center;width: 100%;">
                    <div id="curve_chart2" class="chart" style="margin-left: 140px;"></div>
                </div>
            </div>
            {{--패널 헤더 풋터--}}
            <div class="panel-body" style="padding: 10px 0px 0px 0px;background-color: white">
                <ul class="nav main-nav" style="padding: 0px;">
                    <li class="">
                        <a href="#">학생관리</a>
                    </li>
                    <li class="">
                        <a href="#">피드백</a>
                    </li>
                </ul>
            </div>
        </div>

        {{--패널 바디--}}
        <div class="content animate-panel content-main" style="padding: 15px 0px 15px 0px;">
            <div class="hpanel ccpanel">

                {{--학생 레이어--}}
                <div class="content" style="padding-top: 0px;">
                    <div class="row class-info-layer class-set-list">
                        <div class="col-sm-12">
                            <div class="row owner-tools before">
                                <div class="col-xs-6" style="padding: 6px 15px;">
                                    학생 1명
                                </div>
                            </div>
                            <form id="selectedSetForm" method="post">
                                <input type="hidden" name="class_idx" value="17075">
                                <div class="mem-list-body">
                                    <div class="hpanel collapsed">
                                        <div class="panel-heading hbuilt">
                                            <div class="owner-mem-row">
                                                <div class="row">
                                                    <strong class="user-name">김승목</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hpanel collapsed">
                                        <div class="panel-heading hbuilt">
                                            <div class="owner-mem-row">
                                                <div class="row">
                                                    <div class="col-xs-5" style="width: 40%;">
                                                        <img src="/images/main/img_no_member02.png" class="profile-img m-r-sm" alt="logo" style="width:35px;">
                                                        <strong class="user-name" style="opacity: 0.3;">초대해 주세요</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style=" display:none;">
                                        </div>
                                    </div>
                                    <div class="hpanel collapsed">
                                        <div class="panel-heading hbuilt">
                                            <div class="owner-mem-row">
                                                <div class="row">
                                                    <div class="col-xs-5" style="width: 40%;">
                                                        <img src="/images/main/img_no_member02.png" class="profile-img m-r-sm" alt="logo" style="width:35px;">
                                                        <strong class="user-name" style="opacity: 0.3;">초대해 주세요</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style=" display:none;">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


                {{--피드백 레이어--}}
                <div class="content" style="padding-top: 0px;" id="feedback">
                    <div class="row class-info-layer class-set-list">

                        <div class="col-sm-12">
                            <div class="row owner-tools before">
                                <div class="col-xs-6" style="padding: 6px 15px;">
                                    학생 1명
                                </div>
                            </div>
                            <form id="selectedSetForm" method="post">
                                <input type="hidden" name="class_idx" value="17075">
                                <div class="mem-list-body">
                                    <div class="hpanel collapsed">
                                        <div class="panel-heading hbuilt">
                                            <div class="owner-mem-row">
                                                <div class="row">
                                                    <strong class="user-name">김승목</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hpanel collapsed">
                                        <div class="panel-heading hbuilt">
                                            <div class="owner-mem-row">
                                                <div class="row">
                                                    <div class="col-xs-5" style="width: 40%;">
                                                        <img src="/images/main/img_no_member02.png" class="profile-img m-r-sm" alt="logo" style="width:35px;">
                                                        <strong class="user-name" style="opacity: 0.3;">초대해 주세요</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style=" display:none;">
                                        </div>
                                    </div>
                                    <div class="hpanel collapsed">
                                        <div class="panel-heading hbuilt">
                                            <div class="owner-mem-row">
                                                <div class="row">
                                                    <div class="col-xs-5" style="width: 40%;">
                                                        <img src="/images/main/img_no_member02.png" class="profile-img m-r-sm" alt="logo" style="width:35px;">
                                                        <strong class="user-name" style="opacity: 0.3;">초대해 주세요</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body" style=" display:none;">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


        </div>
    </div>


</div>