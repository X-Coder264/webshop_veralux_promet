@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Korisnički profil
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Narudžba #{{$order->id}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Admin Panel
                </a>
            </li>
            <li>
                <a href="#">Narudžbe</a>
            </li>
            <li class="active">Narudžba #{{$order->id}}</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action ="{{route('admin.user.order.update', $order->id)}}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span>Narudžba #{{$order->id}}</span>
                    </div>

                    <div class="panel-body">
                        <div class="panel-footer">
                            @foreach ($user->toArray() as $key => $value)
                                @if($value != "")
                                    {{$value}} <br>
                                @endif
                            @endforeach
                            <br>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
                        <table class="table table-bordered" id="table_orders">
                            <thead>
                            <tr class="filters">
                                <th>Proizvod</th>
                                <th>Količina</th>
                                <th>Mjerna jedinica</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderProducts as $orderProduct)
                               <tr>
                                   <td style="width:45%;">
                                       @if(! $orderProduct->product->trashed())
                                           <a href="{{route('product.show', $orderProduct->product->slug)}}">{{$orderProduct->product->name}}</a>
                                       @else
                                           <p>{{$orderProduct->product->name}}</p>
                                       @endif
                                   </td>
                                   <td style="width:45%;">{{$orderProduct->quantity}}</td>
                                   <td style="width:10%;">{{$orderProduct->product->unit}}</td>
                               </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{--<div class="panel-footer">&nbsp;
                            <hr>
                            <div class="clear">
                                <input type="button" class="btn btn-danger" value="Povratak">
                                <input type="submit" class="btn btn-primary pull-right" value="Spremi promjene">
                            </div>
                        </div>--}}
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>
@stop
