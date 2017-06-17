@extends('layouts.app')

@section('content')
    <div class="container main-container headerOffset">
        {{-- Main component call to action --}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                                    {{--/.productFilter--}}
                                    @if($count = $products->count())
                                        <div class="row categoryProduct xsResponse clearfix">
                                            <h2>Pronađeno: {{$count}} proizvoda</h2>
                                            @foreach($products as $product)
                                                <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6 cursor-pointer" onclick="window.location='{{route('product.show', $product->slug)}}';">
                                                    <div class="product">
                                                        <div class="image">
                                                            <a href="/trgovina/proizvod/{{ $product->slug }}">
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
                                            <strong>Nije pronađen niti jedan proizvod.</strong>
                                        </div>
                                    @endif
                                    {{--/.categoryProduct || product content end--}}
                                    @if(! isset($_GET['numberPerPage']) || (isset($_GET['numberPerPage']) && $_GET['numberPerPage'] != 0))
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