<!DOCTYPE html>
<!--[if IE 8 ]>
<html class="ie8" lang="en"><![endif]-->
<!--[if IE 9 ]>
<html class="ie9" lang="en"><![endif]-->
<!--[if (gte IE 10)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"><!--<![endif]-->
<head>
    <title>@yield('meta_title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Seo Meta -->
    <meta name="description" content="@yield('meta_description')">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="/style.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/styles/custom.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/styles/dark.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/styles/icons.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/styles/animate.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/styles/responsive.css" media="screen"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500' rel='stylesheet' type='text/css'>

    <!-- Custom Style -->
    <style>
        body {
            background: url('/images/backgrounds/9.jpg') fixed repeat
        }
        #breadcrumb li:after {
            content: '>';
            display: inline-block;
            width: 1em;
            padding-left: 4px;
        }
        #breadcrumb li:last-child:after {
            content: '';
        }
    </style>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/favicon.ico">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">

    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=EmulateIE8; IE=EDGE"/>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div id="layout" class="boxed full">
    <header id="header">

        <div class="row clearfix full-width">
            <div class="sticky_true">
                <div class="c_head clearfix">
                    <!-- NAVIGATION -->
                @widget('appNavigation')
                <!-- NAVIGATION /-->
                    {{--<div class="right_icons">--}}

                        {{--<div class="search">--}}
                            {{--<div class="search_icon"><i class="fa-search"></i></div>--}}
                            {{--<div class="s_form">--}}
                                {{--<form action="search_result.html" id="search" method="get">--}}
                                    {{--<input id="inputhead" name="search" type="text"--}}
                                           {{--onfocus="if (this.value=='Что ищем ...') this.value = '';"--}}
                                           {{--onblur="if (this.value=='') this.value = 'Что ищем ...';"--}}
                                           {{--value="Что ищем ..." placeholder="Что ищем ...">--}}
                                    {{--<button type="submit"><i class="fa-search"></i></button>--}}
                                {{--</form><!-- /form -->--}}
                            {{--</div><!-- /s form -->--}}
                        {{--</div><!-- /search -->--}}
                    {{--</div><!-- /right icons -->--}}
                </div><!-- /c head -->
            </div><!-- /sticky -->
        </div><!-- /row -->
    </header><!-- /header -->
    @yield('content')
    <footer id="footer">
        <div class="row clearfix">
            <div class="grid_3">
                <div class="widget">
                    <div class="title"><h4>О сайте</h4></div>
                    @if($siteSettingModel->getValue('about_site'))
                        <p>{{ $siteSettingModel->getValue('about_site') }}</p>
                    @endif
                </div><!-- /widget -->
            </div><!-- /grid3 -->

            <div class="grid_3">
                <div class="widget">
                    <div class="title"><h4>Случайные гайды</h4></div>
                    @if($manualModel->getRandomModels())
                        <ul class="small_posts">
                            @foreach($manualModel->getRandomModels() as $manualRandomModel)
                                <li class="clearfix">
                                    <a class="s_thumb image_hover" href="{{ $manualRandomModel->url }}">
                                        <img width="70" height="70" src="/uploads/{{ $manualRandomModel->image }}"
                                             alt="{{ $manualRandomModel->getAltImage() }}">
                                    </a>
                                    <h3>
                                        <a href="{{ $manualRandomModel->url }}">{{ $manualRandomModel->h1 }}</a>
                                    </h3>
                                    <div class="meta mb">
                                        {{ LocalizedCarbon::instance($manualRandomModel->created_at)->diffForHumans() }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div><!-- /widget -->
            </div><!-- /grid3 -->

            <div class="grid_3">
                <div class="widget">
                    <div class="title"><h4>Случайные статьи</h4></div>
                    @if($articleModel->getRandomModels())
                        <ul class="small_posts">
                            @foreach($articleModel->getRandomModels() as $articleRandomModel)
                                <li class="clearfix">
                                    <a class="s_thumb image_hover" href="{{ $articleRandomModel->url }}">
                                        <img width="70" height="70" src="/uploads/{{ $articleRandomModel->image }}"
                                             alt="{{ $articleRandomModel->getAltImage() }}">
                                    </a>
                                    <h3>
                                        <a href="{{ $articleRandomModel->url }}">{{ $articleRandomModel->h1 }}</a>
                                    </h3>
                                    <div class="meta mb">
                                        {{ LocalizedCarbon::instance($articleRandomModel->created_at)->diffForHumans() }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div><!-- /widget -->
            </div><!-- /grid3 -->

            <div class="grid_3">
                <div class="widget">
                    <div class="title"><h4>Рассылка</h4></div>
                    <p>Подпишись на рассылку и получай отборные материалы по любимой игре еженедельно</p>
                    <form id="newsletters" method="post" action="http://feedburner.google.com/fb/a/mailverify"
                          target="popupwindow"
                          onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=sevenpsd', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
                        <input type="email" onfocus="if (this.value=='Введите ваш Email') this.value = '';"
                               onblur="if (this.value=='') this.value = 'Введите ваш Email';" value="Введите ваш Email"
                               placeholder="Введите ваш Email" required="required">
                        <button type="submit"><i class="icon-checkmark"></i></button>
                    </form>
                </div><!-- /widget -->

                <div class="widget">
                    <div class="title"><h4>Следуйте за нами</h4></div>
                    <div class="social">
                        <a href="#" class="toptip" title="Twitter"><i class="fa-twitter"></i></a>
                        <a href="#" class="toptip" title="Facebook"><i class="fa-facebook"></i></a>
                        <a href="#" class="toptip" title="instagram"><i class="fa-instagram"></i></a>
                    </div><!-- /social -->
                </div><!-- /widget -->
            </div><!-- /grid3 -->

        </div><!-- /row -->

    </footer><!-- /footer -->

</div><!-- /layout -->

<!-- Scripts -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/ipress.js"></script>
<script type="text/javascript" src="/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/js/jquery.ticker.js"></script>
<script type="text/javascript" src="/js/custom.js"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    function date_time(id) {
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
        d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h = date.getHours();
        if (h < 10) {
            h = "0" + h;
        }
        m = date.getMinutes();
        if (m < 10) {
            m = "0" + m;
        }
        s = date.getSeconds();
        if (s < 10) {
            s = "0" + s;
        }
        // result = ''+days[day]+' '+months[month]+' '+d+' '+year+' '+h+':'+m+':'+s;
//        result = '' + days[day] + ' ' + d + ' ' + months[month] + ' ' + year;
//        document.getElementById(id).innerHTML = result;
//        setTimeout('date_time("' + id + '");', '1000');
//        return true;
    }
    window.onload = date_time('date_time');
    /* ]]> */
</script>
</body>
</html>