<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <title>Veralux-Promet d.o.o.</title>
	
    {{-- Fav and touch icons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=qAqK76n9y9">
    <link rel="icon" type="image/png" href="/favicon-32x32.png?v=qAqK76n9y9" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png?v=qAqK76n9y9" sizes="16x16">
    <link rel="manifest" href="/manifest.json?v=qAqK76n9y9">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=qAqK76n9y9">
    <link rel="shortcut icon" href="/favicon.ico?v=qAqK76n9y9">
    <meta name="apple-mobile-web-app-title" content="Veralux-Promet d.o.o.">
    <meta name="application-name" content="Veralux-Promet d.o.o.">
    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
	    {{-- Bootstrap core CSS --}}
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">

    {{-- Custom styles for this template --}}
    <link rel="stylesheet" href="/assets/css/style.min.css">

    <link rel="stylesheet" type="text/css" href="/css/sweetalert.css">
	
	    {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
    <script src="/assets/js/libs/html5shiv/html5shiv.min.js"></script>
    <script src="/assets/js/libs/respond/respond.min.js"></script>
    <![endif]-->
	
	    {{-- include pace script for automatic web page progress bar  --}}
    <script type="text/javascript">
        paceOptions = {
            elements: true
        };
    </script>
    <script type="text/javascript" src="/assets/js/pace.min.js"></script>

    {{-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent --}}
    <script type="text/javascript">
        window.cookieconsent_options = {"message":"Koristimo kolačiće za pružanje boljeg korisničkog iskustva, te funkcionalnosti sustava kupovine. Korištenjem internet stranice Veralux-Promet d.o.o. slažete se s korištenjem kolačića. Za nastavak pregleda i korištenje internet stranice kliknite na gumb \"Slažem se\".","dismiss":"Slažem se","learnMore":"Pročitajte više!","link":"http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm","theme":"dark-bottom"};
    </script>

    <script type="text/javascript" src="/assets/js/cookieconsent.min.js"></script>
    {{-- End Cookie Consent plugin --}}

    @yield('styles')

    <link rel="stylesheet" href="/assets/css/custom.css">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div class="navbar navbar-tshop navbar-fixed-top megamenu" role="navigation">
    @include('partials.navigation')
    <div class="search-full text-right">
        <a class="pull-right search-close">
            <i class=" fa fa-times-circle"></i>
        </a>
        <div class="searchInputBox pull-right">
            <form method="GET" action="{{route('products.search')}}">
                <input name="search" placeholder="Upišite naziv proizvoda" class="search search-input">
                <button class="btn-nobg search-btn" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    {{--/.search-full--}}
    </div>

    @yield('content')

{{--/.footer--}}
<footer class="footer-js">
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-3 col-sm-4 col-xs-6">
                    <h3> Podrška </h3>
                    <ul>
                        <li class="supportLi">
                            <h4>
                                <a class="inline" href="tel:38549236059">
                                    <strong>
                                        <i class="fa fa-phone"></i> +385 49 236 059
                                    </strong>
                                </a>
                            </h4>
                            <h4>
                                <a class="inline" style="direction: rtl; unicode-bidi: bidi-override;" href="mailto:info@veraluxpromet.hr">rh.temorpxularev@ofni
                                    <i class="fa fa-envelope-o"></i>
                                </a>
                            </h4>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3>Trgovina</h3>
                    <ul>
                        <li><a href="{{route('shop')}}">Kategorije proizvoda</a></li>
                    </ul>
                </div>

                <div style="clear:both" class="hide visible-xs"></div>

                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <h3>Informacije</h3>
                    <ul class="list-unstyled footer-nav">
                        <li><a href="{{route('support_form')}}">Pošalji upit</a></li>
                        <li><a href="{{route('about_us')}}">O nama</a></li>
                        <li><a href="{{route('contact_us')}}">Kontakt</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <h3>Korisnik</h3>
                    <ul>
                        @if(! Auth::check())
                            <li><a href="/login">Prijava</a></li>
                            <li><a href="/register">Registracija</a></li>
                        @else
                            {{--<li><a href="#"> Profil </a></li>--}}
                            <li><a href="{{ route('user.orders.show') }}">Lista narudžbi</a></li>
                            <li><a href="{{ route('user.settings') }}">Profil</a></li>
                            <li><a href="{{ route('user.password.change') }}">Promjena lozinke</a></li>

                        @endif
                    </ul>
                </div>
                <div style="clear:both" class="hide visible-xs"></div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                    <h3>Pretplati se na katalog</h3>
                    <ul>
                        <li>
                            <div class="input-append newsLatterBox text-center">
                                <form method="POST" action="{{route('newsletter.subscribe')}}" id="newsletter">
                                    <input type="email" name="email" class="full text-center" placeholder="E-mail adresa">
                                    <button class="btn bg-gray" type="submit"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Šalji mi katalog</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <ul class="social">
                        <li>
                            <a href="https://www.facebook.com" target="_blank">
                                <i class=" fa fa-facebook">&nbsp;</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            {{--/.row--}}
        </div>
        {{--/.container--}}
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left">&copy; Pragma Once {{ date("Y") }}. Sva prava pridržana.</p>
        </div>
    </div>
    {{--/.footer-bottom--}}
</footer>

    <!-- Scripts -->
{{-- Placed at the end of the document so the pages load faster --}}

<script type="text/javascript" src="/assets/js/jquery/jquery-1.12.4.min.js"></script>

<script src="/js/sweetalert.min.js"></script>
<script>
        $("#newsletter").submit(function (event) {
            event.preventDefault();
            var token = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{route('newsletter.subscribe')}}',
                headers: {'X-CSRF-TOKEN': token},
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                error: function(){
                    console.log("error");
                    swal("Dogodila se greška.", "Molimo pokušajte kasnije!", "error");
                },
                success: function(data) {
                    /*console.log("success");
                     console.log(data);*/
                    if($.isNumeric(data)) {
                        if(data == true) {
                            swal("Uspjeh!", "Uspješno ste se pretplatili na katalog!", "success");
                        } else {
                            swal("Dogodila se greška.", "Molimo pokušajte kasnije!", "error");
                        }
                    }
                    else
                    {
                        var failStart = "";
                        $.each(data.errors, function(index, value) {
                            $.each(value,function(i){
                                failStart += value[i]+"\n";
                            });

                        });
                        swal("Dogodila se greška.", data, "error");
                    }
                }
            });
        });
</script>

<script type="text/javascript" src="/assets/bootstrap/js/bootstrap.min.js"></script>

{{-- include  parallax plugin --}}
<script type="text/javascript" src="/assets/js/jquery.parallax-1.1.min.js"></script>

{{-- include mCustomScrollbar plugin //Custom Scrollbar  --}}
<script type="text/javascript" src="/assets/js/jquery.mCustomScrollbar.min.js"></script>

{{-- include grid.js // for equal Div height  --}}
<script type="text/javascript" src="/assets/js/grids.min.js"></script>

{{-- include touchspin.js // touch friendly input spinner component   --}}
<script type="text/javascript" src="/assets/js/bootstrap.touchspin.min.js"></script>

{{-- include carousel slider plugin  --}}
<script type="text/javascript" src="/assets/js/owl.carousel.min.js"></script>

{{-- include custom script for site  --}}
<script type="text/javascript" src="/assets/js/script.min.js"></script>

@yield('scripts')
</body>
</html>
