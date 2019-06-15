<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>@yield('title', '首页')-{{env('APP_NAME')}}</title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/index.css') }}">
</head>
<body>
    <div class="page" id="page_index">
        <header class="nav">
            <div class="middle">
                <a class="logo" href="/"><img src="{{ asset('home/imgs/logo.png') }}"></a>
                <ul>
                    <li><a  style="border-left: none;"  href="/" title="推荐">推荐</a></li>
                    <li><a href="/Author" title="诗人">诗人</a></li>
                    <li><a  href="/Opus" title="古诗词">古诗词</a></li>
                    <li id="menu_toggle" class="menu-toggle"><div><span></span><span></span><span></span></div></li>
                    <li><a  href="/Guwen" title="古文">古文</a></li>
                    <li><a  style="border-right: none;" href="/Shuji" title="书籍">书籍</a></li>
                </ul>
                <dl id="menu_box">
                    <dd><a  style="border-left: none;"  href="/" title="推荐">推荐</a></li>
                    <dd><a class="crt-menu" href="/Author" title="诗人">诗人</a></li>
                    <dd><a  href="/Opus" title="古诗词">古诗词</a></li>
                    <dd><a  href="/Guwen" title="古文">古文</a></li>
                    <dd><a  style="border-right: none;" href="/Shuji" title="书籍">书籍</a></li>
                </dl>
            </div>
        </header>
        <div class="content">
            <div class="container">
                @yield('left')
                <!-- <div class="fl sidebar-left">
                    <div class="bg-f2f1e3 fl-right">
                        <div class="sontitle">
                            <b>专题</b>
                            <div class="soncontent">
                                <a href="">脑筋急转弯</a>
                                <a href="">脑筋急转弯</a>
                                <a href="">脑筋急转弯</a>
                                <a href="">脑筋急转弯</a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="middle">
             邮箱：1424161506@qq.com&nbsp;&nbsp;|&nbsp;&nbsp;豫ICP备16032485号&nbsp;&nbsp;
        </div>
        <p>本站文章版权归原作作者所有,仅供参考。如侵犯了您的版权,请来信说明,本站立即删除。</p>
    </div>
    <a id="to_top">回到顶部</a>
    <script type="text/javascript" src="{{asset('home/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/index.js')}}"></script>
    </body>
</html>