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
            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
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
                                <input style="font-size: 14px;" min="1" name="quantity" placeholder="Unesite količinu..." type="number" class="form-control input-lg" id="quantity" value="{{old('quantity')}}">
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

                    <div class="product-details-info">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-blank ">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            OPIS PROIZVODA
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                     aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <ul class="discription-list-inner bullet-list list-check">
                                            <li>
                                                <p>
                                                    <span>{!! BBCode::parse($product->description) !!}</span>
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ right column end -->
        </div>
        <!--/.row-->
        <div style="clear:both"></div>
    </div>
    <!-- /.product-details-container -->
</section>

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