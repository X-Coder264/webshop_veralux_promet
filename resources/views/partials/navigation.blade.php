{{-- Fixed navbar start --}}
    <div class="navbar-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                    <div class="pull-left ">
                        <ul class="userMenu ">
                            <li class="phone-number"><a href="callto:38549236059">
                                    <span>
                                        <i class="glyphicon glyphicon-phone-alt "></i>
                                    </span>
                                    <span class="hidden-xs" style="margin-left:5px"> +385 49 236 059</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 no-margin no-padding">
                    <div class="pull-right">
                        @if(Auth::guest())
                            <ul class="userMenu">
                                <li>
                                    <a href="/login">
                                        <i class="glyphicon glyphicon-log-in"></i>
                                        <span class="hidden-xs" style="margin-left:2px">Prijava</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/register">
                                        <i class="glyphicon glyphicon-registration-mark"></i>
                                        <span class="hidden-xs" style="margin-left:2px">Registracija</span>
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul class="userMenu">
                                <li class="dropdown hasUserMenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user() -> name}}<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        @if(Auth::user()->admin)
                                            <li>
                                                <a href="{{route('admin.dashboard')}}">
                                                    <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Admin Panel
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{route('user.orders.show')}}">
                                                <i class="glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;Lista narudžbi
                                            </a>
                                        </li>
                                         <li>
                                            <a href="{{route('user.settings')}}">
                                                <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Profil
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.password.change')}}">
                                                <i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;Promjena lozinke
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ url('/logout') }}"
                                               onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                <i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Odjava
                                            </a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Mobilna navigacija</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{route('cart.show')}}" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart">
                <i class="fa fa-shopping-cart colorWhite"></i>
                <span class="cartRespons colorWhite"> ({{$number_of_products_in_cart}})</span>
            </a>
            {{--}}<a class="navbar-brand " href="/">
                <img height="70" src="/images/veralux.svg" alt="Veralux-promet">
            </a>--}}

            {{-- this part for mobile --}}
            <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
                <div class="input-group">
                    <button class="btn btn-nobg getFullSearch" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                {{-- /input-group --}}
            </div>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li {!! setActive('/') !!}><a href="/">Početna</a></li>
                <li {!! setActive('shop*') !!}><a href="{{route('shop')}}">Kategorije proizvoda</a></li>
                {{--<li {!! setActive('/test') !!}><a href="#">Katalozi</a></li>--}}
                <li {!! setActive('support_form') !!}><a href="{{route('support_form')}}">Pošalji upit </a></li>
                <li {!! setActive('about_us') !!}><a href="{{route('about_us')}}">O nama</a></li>
                <li {!! setActive('contact_us') !!}><a href="{{route('contact_us')}}">Kontakt</a></li>
            </ul>
            {{--- this part will be hidden for mobile version --}}
            <div class="nav navbar-nav navbar-right hidden-xs">
                <div class="dropdown  cartMenu ">
                    <a href="{{route('cart.show')}}" class="dropdown-toggle">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="cartRespons"> ({{$number_of_products_in_cart}})</span>
                    </a>
                </div>
                {{--/.cartMenu--}}
                <div class="search-box">
                    <div class="input-group">
                        <button class="btn btn-nobg getFullSearch" type="button">
                            <i class="fa fa-search"> </i>
                        </button>
                    </div>
                    {{-- /input-group --}}
                </div>
                {{--/.search-box --}}
            </div>
            {{--/.navbar-nav hidden-xs--}}
        </div>
        {{--/.nav-collapse --}}
    </div>
    {{--/.container --}}