@extends('admin/layouts/default')

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/css/awesome-bootstrap-checkbox.css') }}" rel="stylesheet"/>
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Uredi korisnika</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Admin Panel
                </a>
            </li>
            <li>Korisnici</li>
            <li class="active">Uredi korisnika</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    @if ($user->trashed())
                        <div class="alert alert-warning">
                            Ovaj korisnik je deaktiviran te ga ne možete uređivati.
                        </div>
                    @else
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Uredi korisnika - {{ $user->name }} {{ $user->surname }}
                            </h3>
                        <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                        </span>
                        </div>
                        <div class="panel-body">
                            <!--main content-->
                            <div class="row">
                                <div class="col-md-12">
                                    @if (session('success'))
                                        <div class="col-md-offset-2 col-md-10 alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="col-md-offset-2 col-md-10 alert alert-warning">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form id="wizard-validation" action="{{ route('admin.users.update', $user) }}"
                                          method="POST" class="form-horizontal">
                                        {{ method_field('PATCH') }}
                                        {{ csrf_field() }}

                                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                            <label for="name" class="col-sm-2 control-label">Ime *</label>
                                            <div class="col-sm-10">
                                                <input id="name" name="name" type="text"
                                                       placeholder="Ime" class="form-control required"
                                                       value="{!! old('name', $user->name) !!}" required>
                                            </div>
                                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                            <label for="email" class="col-sm-2 control-label">E-mail *</label>
                                            <div class="col-sm-10">
                                                <input id="email" name="email" placeholder="E-mail" type="text"
                                                       class="form-control required email"
                                                       value="{!! old('email', $user->email) !!}" required>
                                            </div>
                                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->first('phone', 'has-error') }}">
                                            <label for="phone" class="col-sm-2 control-label">Telefon</label>
                                            <div class="col-sm-10">
                                                <input id="phone" name="phone" type="text" class="form-control" placeholder="Telefon"
                                                       value="{!! old('phone', $user->phone) !!}">
                                            </div>
                                            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->first('company', 'has-error') }}">
                                            <label for="company" class="col-sm-2 control-label">Tvrtka</label>
                                            <div class="col-sm-10">
                                                <input id="company" name="company" type="text" class="form-control" placeholder="Tvrtka"
                                                       value="{!! old('company', $user->company) !!}">
                                            </div>
                                            {!! $errors->first('company', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->first('company_id', 'has-error') }}">
                                            <label for="company_id" class="col-sm-2 control-label">OIB tvrtke</label>
                                            <div class="col-sm-10">
                                                <input id="company_id" name="company_id" type="text" class="form-control" placeholder="OIB tvrtke"
                                                       value="{!! old('company_id', $user->company_id) !!}">
                                            </div>
                                            {!! $errors->first('company_id', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->first('place', 'has-error') }}">
                                            <label for="place" class="col-sm-2 control-label">Mjesto</label>
                                            <div class="col-sm-10">
                                                <input id="place" name="city" type="text" class="form-control" placeholder="Mjesto"
                                                       value="{!! old('city', $user->city) !!}" required>
                                            </div>
                                            {!! $errors->first('place', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->first('address', 'has-error') }}">
                                            <label for="address" class="col-sm-2 control-label">Adresa</label>
                                            <div class="col-sm-10">
                                                <input id="address" name="address" type="text" class="form-control" placeholder="Adresa"
                                                       value="{!! old('address', $user->address) !!}" required>
                                            </div>
                                            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->first('post', 'has-error') }}">
                                            <label for="post" class="col-sm-2 control-label">Poštanski broj</label>
                                            <div class="col-sm-10">
                                                <input id="post" name="postal" type="text" class="form-control" placeholder="Poštanski broj"
                                                       value="{!! old('postal', $user->postal) !!}" required>
                                            </div>
                                            {!! $errors->first('post', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        @if(Auth::user()->id !== $user->id)
                                        <div class="form-group checkbox checkbox-primary">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <input id="admin" name="admin" type="checkbox" class="form-control" @if($user->admin) checked @endif>
                                                <label for="admin">Administrator</label>
                                            </div>
                                        </div>
                                        <br>
                                        @endif
                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-md-10">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    Spremi promjene
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--main content end-->
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@stop
