<style>
    .content {
        padding: 25px;
        min-width: 320px;
    }
    .title-content {
        padding-top: 0px;
        padding-bottom: 0px;
    }
    .panel {
        background: #8ebd4d;
        color: #fff;
        border: none;
    }
    .content {
        padding: 25px;
        min-width: 320px;
    }
    .content-main {
        padding: 15px 25px;
    }
    .hpanel {
        border: none;
        box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        background: #fff;
    }
    .hpanel > .panel-heading {
        color: inherit;
        font-weight: 600;
        padding: 10px 4px;
        transition: all .3s;
        border: 1px solid transparent;
        border-left: 1px solid #e5e6e8;
        border-right: 1px solid #e5e6e8;
    }
    .hpanel.ccpanel .hbuilt.panel-heading {
        padding: 20px 30px;
        padding-bottom: 0px;
        font-size: 18px;
        border-bottom: none;
    }
    .hpanel.ccpanel .panel-body {
        border: 1px solid #e5e6e8;
        border-top: none;
    }
    .main-nav {
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        /*padding-left: 125px;*/
    }
    .main-nav > li {
        display: inline-block;
        border-bottom: 3px solid transparent;
        margin: 0px 5px;
    }
    .main-nav > li:first-child { margin-left: 0px; }
    .main-nav > li:last-child { margin-right: 0px; }
    .main-nav > li > a:hover, .main-nav > li > a:focus { background-color: transparent; }
    .main-nav.mypage > li > a { color: #aaa; font-size: 16px; }
    .main-nav > li.active, .main-nav > li:hover { border-bottom: 3px solid #3498db; }
    .main-nav > li.active > a, .main-nav > li > a:hover { color: #3498db; }

    .make-set-btns {
        margin-top: 12px;
        font-size: 15px;
        font-weight: normal;
    }
    .timeline-body .recent-content { border-bottom: 1px solid #eee; margin-left: 30px; padding: 7px 0px 3px; }
    .timeline-body .class-row:last-child .recent-content { border-bottom: none; }

    #wrapper_body { max-width: 1180px; margin: 0px auto; background-color: #f7f8fa; }

</style>

{{--메인 페이지--}}
<div id="wrapper_body">

    {{--헤드라인--}}
    <div class="content title-content" style="padding-top: 20px;">
        <div class="panel" style="margin-bottom: 0px;">
            <div class="panel-body" style="background-color: #d6e8ec; border-top: none; position: relative; padding: 10px;">
                <div style="margin-left: 10px;padding-top: 25px;font-size: 24px; font-weight: 600;height:80px;">
                        나의 문제
                </div>
            </div>
        </div>
    </div>

    {{--레이스 리스트--}}
    <div class="content animate-panel content-main">
        <div class="hpanel ccpanel">

            {{--레이스 목록 헤더--}}
            <div class="panel-heading hbuilt ">
                {{--레이스 찾기--}}
                <div class="pull-right">

                    <div class="make-set-btns">
                        <form id="" method="get" style="display: inline;">
                            <div class="form-group has-feedback" style="margin-bottom: 0px;">
                                <input type="text" class="form-control input-sm" id="" value="" aria-describedby="makeqStatus" placeholder="만든 레이스 검색" title="만든 레이스 검색" required="" style="display: inline-block; width: 150px; height:29px;">
                                <a class="glyphicon glyphicon-search form-control-feedback btn-search" aria-hidden="true" style="pointer-events:auto; border: 0px; background-color: transparent;"></a>
                            </div>
                        </form>
                    </div>
                </div>

                {{--레이스 목록 헤더 종류--}}
                <ul class="nav main-nav mypage " style="padding: 0px; text-align: left;">
                    <li class=""><a class="make-set-tab" href="#recent_set" data-toggle="tab">이용한 문제</a></li>
                    <li class="active"><a class="make-set-tab" href="#make_set" data-toggle="tab">만든 문제</a></li>
                </ul>
            </div>

            {{--레이스 목록 바디--}}
            <div class="panel-body">
                <div class="tab-content">

                    {{--이용한 문제 목록--}}
                    <div role="tabpanel" class="tab-pane" id="recent_set">
                        <div class="timeline-body">
                            <div class="row class-row row-set-tools" style="cursor: default;">
                                <div class="col-xs-12" style="min-height: 50px;">
                                    <div class="date text-right">
                                        2문제
                                    </div>

                                    <div class="recent-content" style="">
                                        <div style="display: table; min-height: 50px;width: 100%;">
                                            <div class="font-bold" style="position:relative;display: table-cell;vertical-align: middle; font-size: 18px;">
                                                <a class="anchor-underline set-title-search" href="">테스트1 </a>

                                                <div style="font-size: 12px;display: inline;margin-left:380px">작성자 : 누구누구</div>
                                                <div style="font-size: 12px;display: inline;margin-left:10px">날짜 : 2018년 04월 26일</div>

                                                <div class="dropdown" style="display: inline;border-left: 1px solid #e5e6e8;padding-left: 10px;">
                                                    <a class="btn-learn-tools btn btn-sm btn-info btn-radius m-r-sm" data-toggle="dropdown" aria-expanded="false">학습 도구</a>
                                                    <ul class="dropdown-menu" style="margin-top: 15px;">
                                                        <li><a onclick="document.location = '';">레이스 출제하기</a></li>
                                                        <li><a onclick="document.location = '';">프린트 하기</a></li>
                                                    </ul>
                                                </div>

                                                <a class="btn btn-sm btn-info btn-radius" onclick="$('#').modal('show').find('.modal-content');">성적표</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row class-row row-set-tools" style="cursor: default;">
                                <div class="col-xs-12" style="min-height: 50px;">
                                    <span class="icon set-icon word " style=""></span>

                                    <div class="date text-right">
                                        4문제
                                    </div>

                                    <div class="recent-content" style="">
                                        <div style="display: table; min-height: 50px;">
                                            <div class="font-bold" style="position:relative;display: table-cell;vertical-align: middle; font-size: 18px;">
                                                <a class="anchor-underline set-title-search" href="">asdasd </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row class-row row-set-tools" style="cursor: default;">
                                <div class="col-xs-12" style="min-height: 50px;">
                                    <span class="icon set-icon word " style=""></span>

                                    <div class="date text-right">
                                        37문제
                                    </div>

                                    <div class="recent-content" style="">
                                        <div style="display: table; min-height: 50px;">
                                            <div class="font-bold" style="position:relative;display: table-cell;vertical-align: middle; font-size: 18px;">
                                                <a class="anchor-underline set-title-search" href="">스쿠스쿠 1 </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row class-row row-set-tools" data-idx="351" style="cursor: default;">
                                <div class="col-xs-12" style="min-height: 50px;">
                                    <span class="icon set-icon word " style=""></span>

                                    <div class="date text-right">
                                        20문제
                                    </div>

                                    <div class="recent-content" style="">
                                        <div style="display: table; min-height: 50px;">
                                            <div class="font-bold" style="position:relative;display: table-cell;vertical-align: middle; font-size: 18px;">
                                                <a class="anchor-underline set-title-search" href="">급소공략 </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row class-row row-set-tools"style="cursor: default;">
                                <div class="col-xs-12" style="min-height: 50px;">
                                    <span class="icon set-icon word " style=""></span>

                                    <div class="date text-right">
                                        39문제
                                    </div>

                                    <div class="recent-content" style="">
                                        <div style="display: table; min-height: 50px;">
                                            <div class="font-bold" style="position:relative;display: table-cell;vertical-align: middle; font-size: 18px;">
                                                <a class="anchor-underline set-title-search" href="">일본인들이 매일 쓰는 단어 (전체)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-recent-more text-center hidden" style="padding: 20px 0px 5px; cursor: pointer; font-size: 16px; font-weight: 600;">
                            더보기
                        </div>

                    </div>

                    {{--만든 문제 목록--}}
                    <div role="tabpanel" class="tab-pane active" id="make_set">
                        <div class="timeline-body">
                            <div class="row class-row row-set-tools " data-idx="181331" style="cursor: default;">
                                <div class="col-xs-12" style="min-height: 50px;">
                                    <span class="icon set-icon term" style=""></span>

                                    <div class="date text-right">
                                        2문제
                                    </div>

                                    <div class="recent-content" style="">
                                        <div style="display: table; min-height: 50px;">
                                            <div class="font-bold" style="position:relative;display: table-cell;vertical-align: middle; font-size: 18px;">
                                                <a class="anchor-underline set-title-search" href="javascript:goSetMain('181331')">테스트1</a>

                                                <div style="font-size: 12px;display: inline;margin-left:452px">제작날짜 : 2018년 04월 26일</div>

                                                <div class="dropdown" style="display: inline;border-left: 1px solid #e5e6e8;padding-left: 10px;">
                                                    <a class="btn-learn-tools btn btn-sm btn-info btn-radius m-r-sm" data-toggle="dropdown" aria-expanded="false">학습 도구</a>
                                                    <ul class="dropdown-menu" style="margin-top: 15px;">
                                                        <li><a onclick="document.location = '';">레이스 출제하기</a></li>
                                                        <li><a onclick="document.location = '';">프린트 하기</a></li>
                                                    </ul>
                                                </div>

                                                <a class="btn btn-sm btn-info btn-radius" onclick="$('#').modal('show').find('.modal-content');">공유하기</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row class-row row-set-tools " data-idx="130442" style="cursor: default;">
                                <div class="col-xs-12" style="min-height: 50px;">
                                    <span class="icon set-icon word" style=""></span>

                                    <div class="date text-right">
                                        4문제
                                    </div>

                                    <div class="recent-content" style="">
                                        <div style="display: table; min-height: 50px;">
                                            <div class="font-bold" style="position:relative;display: table-cell;vertical-align: middle; font-size: 18px;">
                                                <a class="anchor-underline set-title-search" href="javascript:goSetMain('130442')">asdasd</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-make-more text-center hidden" style="padding: 20px 0px 5px; cursor: pointer; font-size: 16px; font-weight: 600;">
                            더보기
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>