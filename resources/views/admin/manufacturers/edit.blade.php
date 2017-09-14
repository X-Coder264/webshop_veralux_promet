@extends('admin/layouts/default')

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>
            Uređivanje proizvođača
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Admin Panel
                </a>
            </li>
            <li><a href="#">Proizvođači</a></li>
            <li class="active">Uređivanje proizvođača</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Uredite proizvođača
                        </h3>
                        <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="col-md-12 alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="col-md-12 alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.manufacturers.update', $manufacturer) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group">
                                <label for="name" class="control-label">Naziv proizvođača:</label>
                                <input id="name" name="name" type="text"
                                       placeholder="Naziv proizvođača" class="form-control required"
                                       value="{{ $manufacturer->name }}" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Uredi proizvođača</button>
                            </div>

                            <!--ends--> </form></div>
                </div>


                <!--select-->
            </div>
            <!--col-md-6 ends-->
            <!--col-md-6 ends-->

            <!--col-md-6 ends-->
        </div>
        <!--main content ends-->
    </section>
    <!-- content -->

@stop