@extends('layouts.app')

@section('content')
<div class="container main-container headerOffset">
    <!--/.row-->
    <div class="row">
        <div class="col-lg-12 ">
            <div class="row userInfo">
                <div class="thanxContent text-center">
                    <h1>Hvala Vam na narudžbi <a href="#">#{{$order->id}}</a></h1>
                </div>
                <div class="col-lg-7 col-center">
                    <div class="cartContent table-responsive w100">
                        <table style="width:100%" class="cartTable cartTableBorder">
                            <tbody>
                            <tr class="CartProduct cartTableHeader">
                                <td colspan="2"> Artikli koje ste naručili</td>
                                <td style="width:15%"></td>
                            </tr>
                            @foreach($order->orderProducts as $orderProduct)
                                <tr class="CartProduct">
                                    <td class="CartProductThumb">
                                        <div><a href="{{route('product.show', $orderProduct->product->slug)}}"><img src="/product_images/{{ $orderProduct->product->slug }}/{{$orderProduct->product->main_image}}" alt="img"></a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="CartDescription">
                                            <h4><a href="{{route('product.show', $orderProduct->product->slug)}}">{{$orderProduct->product->name}}</a></h4>
                                            <span class="size">{{ $orderProduct->quantity }} {{ $orderProduct->product->unit }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/row end-->
        </div>
        <!--/rightSidebar-->
    </div>
    <!--/row-->
    <div style="clear:both"></div>
</div>
<!-- /.main-container -->
<div class="gap"></div>
@endsection
