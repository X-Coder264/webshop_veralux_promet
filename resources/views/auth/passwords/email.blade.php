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
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Resetiranje lozinke</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning-resend'))
                        <div class="alert alert-warning">
                            {{ session('warning-resend') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-mail adresa</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="g-recaptcha" data-sitekey="6LcS7DAUAAAAAI2knOSub-2YmiVabN3P789VplXV"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                                <br>
                                <button type="submit" class="btn btn-primary btn-block">
                                    Pošalji mi link za promjenu lozinke
                                </button>
                            </div>
                        </div>
                        @if (session('warning-resend'))
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <a href="{{ url('/email-verification-resend') }}">Ponovno slanje aktivacijske poveznice</a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection