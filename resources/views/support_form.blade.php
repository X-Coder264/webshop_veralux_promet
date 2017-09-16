@extends('layouts.app')

@section('content')
<div class="container main-container headerOffset">
    <div class="row">
        <form method="post" action="{{route('support_form_post')}}">
            {{ csrf_field() }}
            <div class="panel panel-default col-xs-12 col-sm-8 col-sm-offset-2 col-md-7 col-md-offset-3 col-lg-6 col-lg-offset-3">
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
                    <div class="text-center">
                        <img style="margin-bottom:10px" height="150" alt="Veralux-promet d.o.o." src="/images/veralux-promet.svg">
                        <h3>Brzo i jednostavno pošaljite upit</h3>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Vaše ime:</label>
                        <input type="text" name="sender_name" class="form-control" @if(Auth::check()) value="{{Auth::user()->name}}"@endif>
                        @if ($errors->has('sender_name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('sender_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Vaša e-mail adresa:</label>
                        <input type="email" name="sender_email" class="form-control" @if(Auth::check()) value="{{Auth::user()->email}}"@endif>
                        @if ($errors->has('sender_email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('sender_email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Naslov poruke:</label>
                        <input type="text" name="subject" class="form-control">
                        @if ($errors->has('subject'))
                            <span class="help-block">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Tekst poruke:</label>
                        <textarea style="resize:vertical;" name="message" class="form-control" rows="4"></textarea>
                        @if ($errors->has('message'))
                            <span class="help-block">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LcS7DAUAAAAAI2knOSub-2YmiVabN3P789VplXV"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="submit" id="submit" class="btn btn-success" value="Pošalji upit">
                    </div>
                </div>
            </div>
        </form>
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