@extends('layouts.app')

@section('styles')
<style type="text/css">
    @media screen and (max-width: 364px) {
        .g-recaptcha {
            transform:scale(0.77);
            -webkit-transform:scale(0.77);
            transform-origin:0 0;
            -webkit-transform-origin:0 0;
        }
    }
</style>
@endsection

@section('content')
<div class="container main-container headerOffset">
    <div class="row">
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
        <div class="panel panel-default col-xs-12 col-sm-8 col-sm-offset-2 col-md-7 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="panel-body">
                <div class="text-center">
                    <img style="margin-bottom:10px" height="150" alt="Veralux-promet d.o.o." src="/images/veralux-promet.svg">
                </div><br>
                <form class="regForm" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <div class="alert alert-warning" role="alert">
                        <strong>Polja označena * su obavezna za ispunjavanje</strong>
                    </div>
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>Ime i prezime *</label>
                        <input type="text" class="form-control" name="name" placeholder="Ime i prezime" value="{{ old('name') }}" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>E-mail adresa *</label>
                        <input type="text" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <strong>Lozinka mora sadržavati minimalno 6 znakova</strong>
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>Lozinka *</label>
                        <input type="password" class="form-control" name="password" placeholder="Lozinka" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label>Ponovite lozinku *</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Ponovite lozinku" required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#pravna" data-toggle="collapse" class="collapsed">PRAVNA OSOBA - posjedujem tvrtku <b class="caret"></b></a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="pravna" style="height: 0px;">
                            <div class="panel-body">
                                <div class="form-group {{ $errors->has('company') ? ' has-error' : '' }}">
                                    <label>Naziv tvrtke</label>
                                    <input type="text" class="form-control" name="company" placeholder="Naziv tvrtke" value="{{ old('company') }}">
                                    @if ($errors->has('company'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
                                    <label>OIB tvrtke</label>
                                    <input type="text" class="form-control" name="company_id" placeholder="OIB tvrtke" value="{{ old('company_id') }}">
                                    @if ($errors->has('company_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('post') ? ' has-error' : '' }}">
                        <label>Poštanski broj *</label>
                        <input type="text" class="form-control" name="post" placeholder="Poštanski broj" value="{{ old('post') }}" required>
                        @if ($errors->has('post'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('post') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('place') ? ' has-error' : '' }}">
                        <label>Mjesto *</label>
                        <input type="text" class="form-control" name="place" placeholder="Mjesto" value="{{ old('place') }}" required>
                        @if ($errors->has('place'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('place') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                        <label>Adresa *</label>
                        <input type="text" class="form-control" name="address" placeholder="Adresa" value="{{ old('address') }}" required>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label>Kontakt broj *</label>
                        <input type="text" class="form-control" name="phone" placeholder="Kontakt broj" value="{{ old('phone') }}" required>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LddUCkTAAAAAJKrlEXYQbgUFvETI4ybdl2zeCi9"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                        @endif
                    </div><br>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-user"></i>&nbsp;&nbsp;Registracija</button>
                </form>
            </div>
        </div>
    </div>
    <!--/row end-->
    <div style="clear:both"></div>
</div>
<!-- /wrapper -->
<div class="gap"></div>
@endsection

@section('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection