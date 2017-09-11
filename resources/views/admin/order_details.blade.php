@extends('admin/layouts/default')

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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span>Narudžba #{{$order->id}}</span>
                    </div>
                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <td>Ime i prezime:</td>
                                                <td><p class="user_name_max">{{ $user->name }}</p></td>
                                            </tr>
                                            <tr>
                                                <td>Email:</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Naziv tvrtke:</td>
                                                <td>{{ $user->company }}</td>
                                            </tr>
                                            <tr>
                                                <td>OIB tvrtke:</td>
                                                <td>{{ $user->company_id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Poštanski broj:</td>
                                                <td>{{ $user->postal }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mjesto:</td>
                                                <td>{{ $user->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>Adresa:</td>
                                                <td>{{ $user->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Kontakt broj:</td>
                                                <td>{{ $user->phone }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        @if($order->remark != '')
                            <div class="panel-footer">
                                <div class="clear">
                                    <textarea class="form-control" disabled>{{$order->remark}}</textarea><br>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
