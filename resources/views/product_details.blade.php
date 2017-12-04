@extends('layouts.app')

@section('styles')
<link href="/assets/css/product-details-5.css" rel="stylesheet">

<!-- styles needed by smoothproducts.js for product zoom  -->
<link rel="stylesheet" href="/assets/css/smoothproducts.css">

<script>
    paceOptions = {
        elements: true
    };
</script>
@endsection

@section('content')
<div class="container main-container headerOffset">
    <div class="row transitionfx">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="main-image sp-wrap col-lg-12 no-padding">
                @foreach($product->images as $image)
                    <a href="/product_images/{{ $product->slug }}/{{ $image->path }}">
                        <img src="/product_images/{{ $product->slug }}/{{ $image->path }}" class="img-responsive" alt="{{ $image->path }}">
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-lg-5 col-lg-offset-1 col-md-6 col-sm-5">
            <h3 class="product-title">{{ $product->name }}</h3>
            <h3 class="product-code">Proizvođač: {{ $product->manufacturer->name }}</h3>
            <h3 class="product-code">Kataloško broj: {{ $product->catalogNumber }}</h3>
            @if($product_is_in_cart === false)
            <form method="POST" action="{{ route('cart.store', $product->slug) }}">
            <div class="productFilter productFilterLook2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="filterBox">
                            @if (count($errors) > 0)
                            <div class="alert alert-info">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <input style="font-size: 16px;" min="1" name="quantity" placeholder="Unesite količinu..." type="number" class="form-control input-lg" id="quantity" value="{{old('quantity')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart-actions">
                <div class="addto row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" class="button btn-block btn-cart cart first">
                            {{ csrf_field() }}
                            Dodaj u košaricu
                        </button>
                    </div>
                </div>
            </div>
            </form>
            @else
            <div class="cart-actions">
                <div class="addto row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="alert alert-info" role="alert">
                            <strong>Proizvod je dodan u košaricu. Količinu ovog proizvoda možete promijeniti unutar košarice.</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<section class="section-product-info-bottom">
    <div class="product-details-bottom-bar">
        <div class="container-1400 container">
            <div class="row">
                <div class="col-lg-8">
                    <ul class="nav nav-tabs flat list-unstyled list-inline social-inline" role="tablist">
                        <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Opis proizvoda</a></li>
                        <li role="presentation"><a href="#tab2" aria-controls="profile" role="tab" data-toggle="tab">Upit o proizvodu</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-tab-content">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab1">
            <div class="product-story-inner">
                <div class="container">
                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="hw100 display-table">
                                <div class="hw100 display-table-cell">
                                    <div class="product-story-info-box">
                                        <div class="product-story-info-text">
                                            <p class="desc">{!! $product->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tab2">
            <div class="product-story-inner">
                <div class="container">
                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="hw100 display-table">
                                <div class="hw100 display-table-cell">
                                    <div class="product-story-info-box">
                                        <form method="post" action="{{route('support_form_post')}}">
                                            {{ csrf_field() }}
                                            <div class="panel panel-default col-xs-12 col-sm-8 col-sm-offset-2 col-md-7 col-md-offset-3 col-lg-6 col-lg-offset-2">
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
                                                        <input type="text" name="subject" class="form-control" value="Upit za proizvod - {{$product->name}}">
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
                                                        <div class="g-recaptcha" data-sitekey="6LcS7DAUAAAAAI2knOSub-2YmiVabN3P789VplXV"></div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- jquery-migrate only for product details -->
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<script type="text/javascript" src="/assets/js/smoothproducts.min.js"></script>
@endsection