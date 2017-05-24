@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Dodaj kategoriju
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>
            Dodajte novu (pod)kategoriju
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Admin CP
                </a>
            </li>
            <li>
                <a href="#">Kategorije</a>
            </li>
            <li class="active">
                Dodajte novu (pod)kategoriju
            </li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="bell" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Dodajte novu (pod)kategoriju
                        </h3>
                        <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Nova glavna kategorija</a></li>
                                <li><a data-toggle="tab" href="#menu1">Nova podkategorija</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <h3>Nova glavna kategorija</h3>
                                    <form action="{{ route('admin.categories.create') }}" method="POST">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label for="main_category" class="col-sm-2 control-label">Naziv kategorije</label>
                                            <input id="main_category" name="main_category" type="text"
                                                   placeholder="Naziv kategorije" class="form-control required"
                                                   value="{!! old('main_category') !!}" required>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Dodajte kategoriju</button>
                                        </div>

                                    </form>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <h3>Nova podkategorija</h3>
                                    <form action="{{ route('admin.categories.create') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="select21" class="control-label">
                                                Odaberite za koju kategoriju želite stvoriti podkategoriju
                                            </label>
                                            {!! $selectHTML !!}
                                        </div>

                                        <div class="form-group">
                                            <label for="subcategory" class="col-sm-2 control-label">Naziv podkategorije</label>
                                            <input id="subcategory" name="subcategory" type="text"
                                                   placeholder="Naziv podkategorije" class="form-control required"
                                                   value="{!! old('subcategory') !!}" required>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Dodajte podkategoriju</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!--col-md-6 ends-->
            <!--col-md-6 ends-->

            <!--col-md-6 ends-->
        </div>
        <!--main content ends-->
    </section>
    <!-- content -->

@stop