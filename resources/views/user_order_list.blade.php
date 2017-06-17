@extends('layouts.app')

@section('styles')
<!-- styles needed by footable  -->
<link href="/assets/css/footable-0.1.css" rel="stylesheet" type="text/css"/>
<link href="/assets/css/footable.sortable-0.1.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="container main-container headerOffset">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h1 class="section-title-inner"><span><i class="fa fa-list-alt"></i> Lista narudžbi </span></h1>
            <div class="row userInfo">
                <div class="col-lg-12">
                    <h2 class="block-title-2"> Vaša lista narudžbi </h2>
                </div>
                <div style="clear:both"></div>
                <div class="col-xs-12 col-sm-12">
                    <table class="footable">
                        <thead>
                        <tr>
                            <th data-class="expand" data-sort-initial="true"><span title="table sorted by this column on load">ID narudžbe</span></th>
                            <th data-class="default" data-sort-ignore="false">Broj naručenih artikla</th>
                            {{--<th data-hide="phone,tablet" data-sort-ignore="true">Narudžba PDF:</th>--}}
                            {{--<th data-hide="phone,tablet"><strong>Payment Method</strong></th>--}}
                            {{--<th data-hide="default"> Price</th>--}}
                            <th data-hide="default" data-type="numeric"> Datum</th>
                            <th data-hide="default" data-sort-ignore="true">Opcije</th>
                            {{--<th data-hide="phone" data-type="numeric"> Status</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td data-type="number" data-value="{{$order->id}}">#{{$order->id}}</td>
                                <td>{{$order->orderProducts->count()}} artikl/artikla </td>
                                {{--<td><a target="_blank" href="{{'/users/' . \Auth::user()->slug . '/invoices/' . 'Invoice ' . $order->id .  '.pdf'}}">Narudžba {{$order->id}}</a></td>--}}
                                <td data-type="date" data-value="{{$order->created_at->timestamp}}">{{$order->created_at->format('d.m.Y. H:i:s')}}</td>
                                <td><a href="{{route('user.order.show', $order)}}" class="btn btn-primary btn-md"><i class="fa fa-file"></i>&nbsp;&nbsp;Pogledajte narudžbu</a></td>
                                {{--<td data-value="3"><span class="label label-success">Done</span></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="clear:both"></div>
                <div class="col-lg-12 clearfix">
                    <ul class="pager">
                        <li class="previous pull-right"><a href="{{route('shop')}}"> <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Kategorija proizvoda</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/row end-->
        </div>
    </div>
    <!--/row-->
    <div style="clear:both"></div>
</div>
<!-- /main-container -->
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