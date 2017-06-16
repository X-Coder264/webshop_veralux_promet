@extends('admin/layouts/default')

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
                    Admin Panel
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Dodajte novu (pot)kategoriju
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
                                <li class="active"><a data-toggle="tab" href="#home">Nova kategorija</a></li>
                                <li><a data-toggle="tab" href="#menu1">Nova potkategorija</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <h3>Nova kategorija</h3>
                                    <form action="{{ route('admin.categories.create') }}" method="POST">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label for="main_category" class="control-label">Naziv kategorije</label>
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
                                    <h3>Nova potkategorija</h3>
                                    <form action="{{ route('admin.categories.create') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="select21" class="control-label">
                                                Odaberite za koju kategoriju želite stvoriti potkategoriju
                                            </label>
                                            {!! $selectHTML !!}
                                        </div>

                                        <div class="form-group">
                                            <label for="subcategory" class="control-label">Naziv potkategorije</label>
                                            <input id="subcategory" name="subcategory" type="text"
                                                   placeholder="Naziv potkategorije" class="form-control required"
                                                   value="{!! old('subcategory') !!}" required>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Dodaj potkategoriju</button>
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