@extends('layouts.app')

@section('content')

<div class="banner">
    <div class="full-container">
        <div class="slider-content">
            <ul id="pager2" class="container"></ul>
            {{-- prev/next links --}}
            <span class="prevControl sliderControl">
                <i class="fa fa-angle-left fa-3x "></i>
            </span>
            <span class="nextControl sliderControl">
                <i class="fa fa-angle-right fa-3x "></i>
            </span>
            <div class="slider slider-v1" data-cycle-swipe=true data-cycle-prev=".prevControl" data-cycle-next=".nextControl" data-cycle-loader="wait">
                <div class="slider-item slider-item-img1">
                    <img src="images/slider/slider1.jpg" class="img-responsive parallaximg sliderImg" alt="img">
                </div>
                <div class="slider-item slider-item-img1">
                    <img src="images/slider/slider2.jpg" class="img-responsive parallaximg sliderImg" alt="img">
                </div>
                <div class="slider-item slider-item-img1">
                    <img src="images/slider/slider3.jpg" class="img-responsive parallaximg sliderImg" alt="img">
                </div>
                <div class="slider-item slider-item-img1">
                    <img src="images/slider/slider5.jpg" class="img-responsive parallaximg sliderImg" alt="img">
                </div>
                <div class="slider-item slider-item-img1">
                    <img src="images/slider/slider4.jpg" class="img-responsive parallaximg sliderImg" alt="img">
                </div>
                {{--/.slider-item--}}
            </div>
            {{--/.slider slider-v1--}}
        </div>
        {{--/.slider-content--}}
    </div>
    {{--/.full-container--}}
</div>
{{--/.banner style1--}}

<div class="container main-container">
    {{-- Main component call to action --}}
    @if($products->count())
    <div class="morePost row featuredPostContainer style2 globalPaddingTop">
        <h1 class="title-big text-center section-title-style2" id="discount_products">
            <span>ISTAKNUTI PROIZVODI</span>
        </h1>
        <div class="container">
            <div class="row categoryProduct xsResponse clearfix" id="highlighted-products">
                @foreach($products as $product)
                    <div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6 cursor-pointer" onclick="window.location='{{route('product.show', $product->slug)}}';">
                        <div class="product">
                            <div class="image">
                                <a href="{{route('product.show', $product->slug)}}">
                                        <img src="/product_images/{{ $product->slug }}/{{ $product->mainImage->path }}" alt="img" class="img-responsive">
                                </a>
                                <div class="promotion">
                                    <span class="new-product">Istaknuti proizvod</span>
                                </div>
                            </div>
                            <div class="description">
                                <h4>
                                    <a href="{{route('product.show', $product->slug)}}">{{$product->name}}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--/.item--}}
            </div>
            {{-- /.row --}}
            <div class="row" style="margin-top:20px">
                <div class="load-more-block text-center">
                    <button class="btn btn-thin" id="load-more-button">
                        <i class="fa fa-plus-sign">+</i> učitaj više proizvoda
                    </button>
                </div>
            </div>
        </div>
        {{--/.container--}}
    </div>
    {{--/.featuredPostContainer--}}
    @endif
    <div class="width100 section-block">
        <h3 class="section-title"><span>PARTNERI PROIZVOĐAČI</span>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <ul class="no-margin brand-carousel owl-carousel owl-theme">
                    <li style="margin-right: 5px;"><a href="http://awex.eu/en/" target="_blank"><img src="images/brand/awex-logo.png" alt="awex-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="https://www.beghelli.it/it" target="_blank"><img src="images/brand/beghelli-logo.png" alt="beghelli-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.ccs-cabling.it/index.php?lang=en" target="_blank"><img src="images/brand/ccs-logo.png" alt="ccs-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.cluce.it/index.php" target="_blank"><img src="images/brand/cluce-logo.png" alt="cluce-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.dietal.com/" target="_blank"><img src="images/brand/dietal-logo.png" alt="dietal-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.disano.it/GetHome.pub_do" target="_blank"><img src="images/brand/disano-logo.png" alt="disano-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.dietzel-univolt.com/257_EI" target="_blank"><img src="images/brand/du-logo.png" alt="du-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.elettrocanali.it/" target="_blank"><img src="images/brand/elettrocanali-logo.png" alt="elettrocanali-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.esse-ci.com/" target="_blank"><img src="images/brand/esseci-logo.png" alt="esseci-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.eti.ba/proizvodi-i-usluge" target="_blank"><img src="images/brand/eti-logo.png" alt="eti-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="https://www.hager.com/" target="_blank"><img src="images/brand/hager-logo.png" alt "hager-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.haupa.com/" target="_blank"><img src="images/brand/haupa-logo.png" alt="haupa-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.indel.pl/" target="_blank"><img src="images/brand/indel-logo.png" alt="indel-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://ir-luks.com/" target="_blank"><img src="images/brand/ir_luks-logo.png" alt="ir-luks-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.kopos.hr/site/index.php" target="_blank"><img src="images/brand/kopos-logo.png" alt="kopos-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.legrand.hr/" target="_blank"><img src="images/brand/legrand-logo.png" alt="legrand-logo"></a></li>
                    <li style="margin-right: 5px;"><a href=""><img src="images/brand/lirio-logo.png" alt="lirio-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.lival.com/" target="_blank"><img src="images/brand/lival-logo.png" alt="lival-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.luxiona.pl/en/" target="_blank"><img src="images/brand/luxiona-logo.png" alt="luxiona-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.meanwell.com/" target="_blank"><img src="images/brand/meanwell-logo.png" alt="meanwell-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.nordicaluminium.fi/en/index.html" target="_blank"><img src="images/brand/nordic_aluminium.png" alt="nordic_aluminium"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.performanceinlighting.com/ww/en/" target="_blank"><img src="images/brand/performanceinlighting-logo.png" alt="performanceinlighting-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="https://www.philips.hr/" target="_blank"><img src="images/brand/philips-logo.png" alt="philips-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.rabalux.com/hr_HR/home" target="_blank"><img src="images/brand/rabalux-logo.png" alt="rabalux-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.schneider-electric.com/ww/en/" target="_blank"><img src="images/brand/schneider_electric-logo.png" alt="schneider_electric-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.smrdelplast.si/" target="_blank"><img src="images/brand/sm-logo.png" alt="sm-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.steinel.net/" target="_blank"><img src="images/brand/steinel-logo.png" alt="steinel-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.tem.si/" target="_blank"><img src="images/brand/tem-logo.png" alt="tem-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.teslacables.hr/" target="_blank"><img src="images/brand/tesla-logo.png" alt="tesla-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.trevos.eu/" target="_blank"><img src="images/brand/trevos-logo.png" alt="trevos-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.urmetdomus.it/urmet_web/it/home.html" target="_blank"><img src="images/brand/urmet-logo.png" alt="urmet-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.viko.com.tr/tr/urunler/" target="_blank"><img src="images/brand/viko-logo.png" alt="viko-logo"></a></li>
                    <li style="margin-right: 5px;"><a href="http://www.vimar.com/en/int" target="_blank"><img src="images/brand/vimar-logo.png" alt="vimar-logo"></a></li>
                </ul>
            </div>
        </div>
        <!--/.row-->
    </div>
    <!--/.section-block-->
</div>
{{--main-container--}}
@endsection

@section('scripts')

{{-- include anchor smooth scrolling --}}
<script type="text/javascript">
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
</script>

<script type="text/javascript">
    var page = 2;
    $("#load-more-button").click(function () {
        $.ajax({
            type: 'GET',
            url: "{{route('highlighted_products')}}",
            data: {page: page},
            error: function(){
                console.log("error");
            },
            success: function(data) {
                console.log("success");
                page = page + 1;
                if(data.trim().length == 0) {
                    $("#load-more-button").text("Nema više istaknutih proizvoda!").prop("disabled", true);
                }
                $("#highlighted-products").append(data);
            }
        });
    });
</script>

{{-- include jqueryCycle plugin--}}
<script src="/assets/js/jquery.cycle2.min.js"></script>

{{-- include easing plugin--}}
<script src="/assets/js/jquery.easing.1.3.min.js"></script>

{{-- include custom script for only homepage--}}
<script type="text/javascript" src="/assets/js/home.min.js"></script>

@endsection