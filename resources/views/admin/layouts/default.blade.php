<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            Veralux-Promet d.o.o.
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->

    <link href="{{ asset('assets/css/admin_app.css') }}" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->

    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->

    <link rel="stylesheet" href="/assets/css/custom.css">

<body class="skin-josh">
<header class="header">
    <div class="logo">
        <a href="{{ route('admin.dashboard') }}">
            <img height="100" alt="Veralux-promet" src="/images/veralux-promet-white.svg">
        </a>
    </div>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="riot">
                            <div>
                                <p class="user_name_max">{{ Auth::user()->name }} {{ Auth::user()->surname }}</p>
                                <span class="caret" style="margin-top: -5px;"></span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Body -->
                        <li class="user-footer">
                            <div>
                                <a href="{{ URL::to('/') }}">
                                    <i class="livicon" data-name="desktop" data-s="18"></i>&nbsp;&nbsp;Internet trgovina
                                </a>
                            </div>
                        </li>
                        <li class="divider" style="margin:0;"></li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="livicon" data-name="sign-out" data-s="18"></i>&nbsp;&nbsp;Odjava
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('admin.layouts._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

                <!-- Content -->
        @yield('content')

    </aside>
    <!-- right-side -->
</div>

<!-- global js -->
<script src="{{ asset('assets/js/admin_app.js') }}" type="text/javascript"></script>


<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
        <!-- end page level js -->
</body>
</html>
