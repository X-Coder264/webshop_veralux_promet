@extends('layouts.app')

@section('content')
<div class="container main-container headerOffset">
    {{-- Main component call to action --}}
    <div class="row">
        {{--left column--}}
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="panel-group" id="accordionNo">
                {{--Category--}}
                <div class="panel panel-default has-tree">
                    <div id="collapseCategory" class="panel-collapse collapse in">
                        <div class=" " id="main_nav">
                            {!! $categories !!}
                        </div>
                    </div>
                </div>
                {{--/Category menu end--}}

                @if(isset($category))
                <form method="get" action="{{route('ProductCategory', $category->slug)}}">
                    @elseif(isset($index) && $index === true)
                        <form method="get" action="{{route('shop.products')}}">
                    @else
                        <form method="get">
                    @endif
                            @foreach($_GET as $key => $value)
                                @if($key == 'orderBy' || $key == 'numberPerPage')
                                <input type="hidden" name="{{$key}}" value="{{$value}}">
                                @endif
                            @endforeach
                {{--<div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapseWill active" data-toggle="collapse" href="#collapsePrice">CIJENA
                                <span class="pull-left">
                                    <i class="fa fa-caret-right"></i>
                                </span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapsePrice" class="panel-collapse collapse in">
                        <div class="panel-body priceFilterBody form-inline">
                            <p>Unesite raspon cijena</p>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail2" name="startPrice" placeholder="100"
                                           @if(isset($_GET['startPrice']) && is_numeric($_GET['startPrice']))
                                           value="{{$_GET['startPrice']}}"
                                            @endif>
                                </div>
                                <div class="form-group sp">do</div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputPassword2" name="endPrice" placeholder="500"
                                           @if(isset($_GET['endPrice']) && is_numeric($_GET['endPrice']))
                                           value="{{$_GET['endPrice']}}"
                                            @endif>
                                </div>
                        </div>
                    </div>
                </div>--}}
                {{--/Price panel end--}}

                {{--<div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapseThree" class="collapseWill active ">PRIKAZ
                                <span class="pull-left">
                                    <i class="fa fa-caret-right"></i>
                                </span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="block-element">
                                <label>
                                    <input type="checkbox" name="discount"
                                    @if(isset($_GET['discount']) && $_GET['discount'] == 'on')
                                        checked
                                        @endif> Samo proizvodi na popustu
                                </label>
                            </div>
                        </div>
                    </div>
                </div>--}}
                {{--/discount  panel end--}}
                    {{--<button type="submit" class="btn btn-primary pull-left" style="margin: 10px 0">FILTRIRAJ</button>--}}
                </form>
            </div>
        </div>
        {{--right column--}}
        <div class="col-lg-9 col-md-9 col-sm-12">
            @if(isset($category))
                <form method="get" action="{{route('ProductCategory', $category->slug)}}">
                    @elseif(isset($index) && $index === true)
                        <form method="get" action="{{route('shop.products')}}">
                            @else
                                <form method="get">
                                    @endif
                                    @foreach($_GET as $key => $value)
                                        @if($key == 'startPrice' || $key == 'endPrice' || $key == 'category')
                                            <input type="hidden" name="{{$key}}" value="{{$value}}">
                                        @endif
                                    @endforeach
            <div class="w100 productFilter clearfix">
                <div style="padding-bottom: 10px;" class="row">
                    <div class="col-xs-6 col-sm-5 col-md-5 col-lg-4 pull-left">
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-4 pull-left">
                            <p>Sortiraj: </p>
                        </div>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8 pull-left">
                            <select class="form-control" name="orderBy" onchange="this.form.submit()">
                                <option
                                        @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 0)
                                        selected="selected"
                                        @endif value="0">najnoviji</option>
                                <option
                                        @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 1)
                                        selected="selected"
                                @endif value="1">najstariji</option>
                                {{--<option
                                        @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 2)
                                        selected="selected"
                                @endif value="2">s višom cijenom</option>
                                <option
                                        @if(isset($_GET['orderBy']) && $_GET['orderBy'] == 3)
                                        selected="selected"
                                @endif value="3">s nižom cijenom</option>--}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-5 col-md-5 col-lg-4 pull-right">
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-4 pull-left">
                            <p>Prikaži: </p>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-7 pull-right">
                            <select class="form-control" name="numberPerPage" onchange="this.form.submit()">
                                <option
                                        @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 12)
                                        selected="selected"
                                @endif value="12">12 proizvoda</option>
                                <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 24)
                                        selected="selected"
                                        @endif value="24">24 proizvoda</option>
                                <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 36)
                                        selected="selected"
                                @endif value="36">36 proizvoda</option>
                                <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 48)
                                        selected="selected"
                                @endif value="48">48 proizvoda</option>
                                <option @if(isset($_GET['numberPerPage']) && $_GET['numberPerPage'] == 0)
                                        selected="selected"
                                @endif value="0">sve proizvode</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            {{--/.productFilter--}}
            @if($products->count())
            <div class="row categoryProduct xsResponse clearfix">
                @foreach($products as $product)
                    <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6 cursor-pointer" onclick="window.location='{{route('product.show', $product->slug)}}';">
                        <div class="product">
                            <div class="image">
                                <a href="{{route('product.show', $product->slug)}}">
                                    @if($product->main_image != "")
                                        <img src="/product_images/{{ $product->slug }}/{{ $product->main_image }}" alt="img" class="img-responsive">
                                    @endif
                                </a>
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
            @else
            <div class="alert alert-info" role="alert">
                <strong>U ovoj kategoriji trenutno nema proizvoda.</strong>
            </div>
            @endif
            {{--/.categoryProduct || product content end--}}
            @if(!isset($_GET['numberPerPage']) || (isset($_GET['numberPerPage']) && $_GET['numberPerPage'] != 0))
            <div class="w100 categoryFooter">
                {{ $products->appends($_GET)->links() }}
            </div>
            @endif
            {{--/.categoryFooter--}}
        </div>
        {{--/right column end--}}
    </div>
    {{-- /.row  --}}
</div>
{{-- /main container --}}
<div class="gap"></div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function($){
            var nav_container = $('#main_nav');
            var el = nav_container.find('.active');
            if(el)
            {
                var parent = el.closest('li');

                parent.removeAttr("style");
                parent.attr('style','display: list-item');

                el.parents('ul').siblings('a').each(function(){
                    $(this).removeClass('child-has-close');
                    $(this).addClass('child-has-open');
                });

                el.parents('li').each(function(){
                    $(this).removeAttr("style");
                    $(this).attr('style','display: list-item');
                    $(this).siblings('li').each(function(){
                        $(this).removeAttr("style");
                        $(this).attr('style','display: list-item');
                    });
                });
            }
        });

    </script>
@endsection