@extends('layouts.app')

@section('content')
<div class="container main-container headerOffset">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h1 class="section-title-inner"><span><i class="fa fa-list-alt"></i> Stanje narudžbe</span></h1>
            <div class="row userInfo">
                <div class="col-lg-12">
                    <h2 class="block-title-2">Narudžba broj #{{$order->id}}</h2>
                </div>
                <div class="statusContent">
                    <div class="col-sm-12">
                        <div class=" statusTop">
                            {{--<p><strong>Status:</strong> Naručeno</p>--}}
                            <p><strong>Naručeno:</strong> {{$order->created_at}}</p>
                            <p><strong>Broj narudžbe:</strong> #{{$order->id}} </p>
                        </div>
                    </div>
                    <div class="col-sm-12 clearfix">
                        <div class="order-box">
                            <div class="order-box-header">
                                Naručeni artikli
                            </div>
                            <div class="order-box-content">
                                <div class="table-responsive">
                                    <table class="order-details-cart">
                                        <tbody>
                                        @foreach($order->orderProducts as $orderProduct)
                                            <tr class="cartProduct">
                                                <td class="cartProductThumb">
                                                    <div>
                                                        @if(! $orderProduct->product->trashed())
                                                            <a href="{{route('product.show', $orderProduct->product->slug)}}">
                                                                <img alt="img" src="/product_images/{{ $orderProduct->product->slug }}/{{ $orderProduct->product->main_image }}">
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="miniCartDescription">
                                                        <h4>
                                                            @if(! $orderProduct->product->trashed())
                                                                <a href="{{route('product.show', $orderProduct->product->slug)}}"> {{$orderProduct->product->name}} </a>
                                                            @else
                                                                <p>{{$orderProduct->product->name}}</p>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                </td>
                                                <td><a> X {{$orderProduct->quantity}} </a></td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 clearfix">
                    <ul class="pager">
                        <li class="previous pull-right"><a href="{{route('shop')}}"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Kategorije proizvoda</a>
                        </li>
                        <li class="next pull-left"><a href="{{route('user.orders.show')}}"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Lista narudžbi</a></li>
                    </ul>
                </div>
            </div>
            <!--/row end-->
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5"></div>
    </div>
    <!--/row-->
    <div style="clear:both"></div>
</div>
<!-- /main-container -->

<div class="gap"></div>

@endsection

@section('scripts')
<script src="/assets/js/footable.js" type="text/javascript"></script>
<script src="/assets/js/footable.sortable.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('.footable').footable();
    });
</script>
@endsection