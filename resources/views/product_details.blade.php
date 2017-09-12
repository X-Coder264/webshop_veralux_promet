@extends('layouts.app')

@section('styles')
<link href="/assets/css/product-details-5.css" rel="stylesheet">

<!-- gall-item Gallery for gallery page -->
<link href="/assets/plugins/magnific/magnific-popup.css" rel="stylesheet">


<!-- bxSlider CSS file -->
<link href="/assets/plugins/bxslider/jquery.bxslider.css" rel="stylesheet"/>
<script>
    paceOptions = {
        elements: true
    };
</script>
@endsection

@section('content')
<section class="section-product-info">
    <div class="container-1400 container main-container product-details-container ">
        <div class="row">
            <!-- left column -->
            <div style="margin-bottom:40px;" class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                <div class="product-images-carousel-wrapper">
                    <div class="productMainImage hasWhiteImg">
                        <ul class="bxslider product-view-slides product-view-slides-h ">
                            @foreach($product->images as $image)
                                <li>
                                    <div class='zoomContent'>
                                        <a class="gall-item" title="{{ $image->path }}"
                                           href="/product_images/{{ $product->slug }}/{{ $image->path }}"><img
                                                    class="zoomImage1 img-responsive"
                                                    data-src="/product_images/{{ $product->slug }}/{{ $image->path }}"
                                                    src='/product_images/{{ $product->slug }}/{{ $image->path }}' alt='Image Title'/></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="product-view-thumb-wrapper has-carousel-v hasWhiteImg">
                        <div class="product-view-thumb-nav prev"></div>
                        <ul id="bx-pager" class="product-view-thumb ">
                            <?php $i = 0; ?>
                            @foreach($product->images as $image)
                                <li style="height: auto"><a class="thumb-item-link" data-slide-index="{{$i++}}" href=""><img
                                                src="/product_images/{{ $product->slug }}/{{ $image->path }}" alt="img"/></a></li>
                            @endforeach
                        </ul>
                        <div class="product-view-thumb-nav next"></div>
                    </div>
                </div>
            </div>
            <!--/ left column end -->
            <!-- right column -->
            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                <div class="product-details-info-wrapper">


                    <h2 class="product-details-product-title"> {{ $product->name }}</h2>
                    <h3> Kataloški broj: {{ $product->catalogNumber }}</h3>

                    <form method="POST" action="{{route('cart.store', $product->slug)}}">
                        <div class="row row-filter clearfix ">
                            <div class="col-sm-12">
                                @if (count($errors) > 0)
                                    <div class="alert alert-info">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if($product_is_in_cart === false)
                                <input style="font-size: 16px;" min="1" name="quantity" placeholder="Unesite količinu..." type="number" class="form-control input-lg" id="quantity" value="{{old('quantity')}}">
                            </div>
                        </div>

                        <div class="row row-cart-actions clearfix ">
                            <div class="col-sm-12 ">
                                <button type="submit" class="btn btn-block btn-dark">
                                    {{ csrf_field() }}
                                    Dodaj u košaricu
                                </button>
                                @else
                                 <div class="alert alert-info" role="alert">
                                    <strong>Proizvod je dodan u košaricu. Količinu ovog proizvoda možete promijeniti unutar košarice.</strong>
                                 </div>
                                @endif
                            </div>
                        </div>
                        <div style="clear:both"></div>
                    </form>
                </div>
            </div>
            <!--/ right column end -->
        </div>
        <!--/.row-->
    </div>
    <!-- /.product-details-container -->
</section>

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Opis proizvoda</a></li>
    <li><a data-toggle="tab" href="#menu1">Upit o proizvodu</a></li>
</ul>

<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        <div class="product-story-inner ">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 ">
                        <div class="hw100 display-table">
                            <div class="hw100 display-table-cell">
                                <div class="product-story-info-box">
                                    <div class="product-story-info-text ">
                                        <p class="desc">{!! BBCode::parse($product->description) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="menu1" class="tab-pane fade">
        <div class="row">
            <form method="post" action="{{route('support_form_post')}}">
            <div class="panel panel-default col-xs-12 col-sm-8 col-sm-offset-2 col-md-7 col-md-offset-3 col-lg-6 col-lg-offset-3">
                <div class="panel-body">
                    <div class="text-center">
                        <img style="margin-bottom:10px" height="150" alt="Veralux-promet d.o.o." src="/images/veralux-promet.svg">
                        <h3>Brzo i jednostavno pošaljite upit</h3>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Vaše ime:</label>
                        <input type="text" name="sender_name" class="form-control" @if(Auth::check()) value="{{Auth::user()->name}}"@endif>
                        @if ($errors->has('sender_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('sender_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Vaša e-mail adresa:</label>
                        <input type="email" name="sender_email" class="form-control" @if(Auth::check()) value="{{Auth::user()->email}}"@endif>
                        @if ($errors->has('sender_email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('sender_email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Naslov poruke:</label>
                        <input type="text" name="subject" class="form-control" value="Upit za proizvod idiote - {{$product->name}}" disabled>
                        @if ($errors->has('subject'))
                            <span class="help-block">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Tekst poruke:</label>
                        <textarea style="resize:vertical;" name="message" class="form-control" rows="4"></textarea>
                        @if ($errors->has('message'))
                            <span class="help-block">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LddUCkTAAAAAJKrlEXYQbgUFvETI4ybdl2zeCi9"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" id="submit" class="btn btn-success" value="Pošalji upit">
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="/assets/plugins/magnific/jquery.magnific-popup.min.js"></script>
<script>
    $(document).ready(function () {

        $('#bx-pager .popup-youtube, #bx-pager .popup-vimeo, #bx-pager .popup-gmaps').click(function (ev) {
            // stop click event in bxslider
            ev.preventDefault();
            ev.stopPropagation();
        });
    });
</script>

<script src='/assets/js/jquery.zoom.js'></script>
<script>
    $(document).ready(function () {

        // Product ZOOM

        $('.zoomContent').zoom();


        $('.gall-item').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        // Fake Click Event to show popup

        $(".zoomContent").click(function () {
            $(this).find('.gall-item').trigger('click');
        });
    });
</script>
<!-- bxSlider Javascript file -->
<script src="/assets/plugins/bxslider/plugins/jquery.fitvids.js"></script>
<script src="/assets/plugins/bxslider/jquery.bxslider.min.js"></script>
<script>

    $(document).ready(function () {

        var $$mainImgSliderPager = $('#bx-pager');

        // Slider
        var $mainImgSlider = $('.bxslider').bxSlider({
            pagerCustom: '#bx-pager',
            video: true,
            useCSS: false,
            mode: 'vertical',
            touchEnabled: false,
            controls: false
        });

        // initiates responsive slide
        var settings = function () {
            var mobileSettings = {
                slideWidth: 60,
                minSlides: 2,
                maxSlides: 4,
                slideMargin: 10,
                controls: false

            };
            var pcSettings = {
                mode: 'vertical',
                minSlides: 4,
                pager: false,
                slideMargin: 10,
                nextSelector: '.product-view-thumb-nav.next',
                prevSelector: '.product-view-thumb-nav.prev',
                nextText: ' <i class="fa fa-angle-down"></i>',
                prevText: ' <i class="fa fa-angle-up"></i>'
            };
            return ($(window).width() < 768) ? mobileSettings : pcSettings;
        }

        var thumbSlider;

        function tourLandingScript() {
            thumbSlider.reloadSlider(settings());
        }

        thumbSlider = $('.has-carousel-v .product-view-thumb').bxSlider(settings());
        $(window).resize(tourLandingScript);

    });
</script>
@endsection