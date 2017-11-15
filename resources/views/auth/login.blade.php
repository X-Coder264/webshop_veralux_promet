@extends('layouts.app')

@section('content')
<div class="container main-container headerOffset">
    <div class="row">
        <div class="panel panel-default col-xs-12 col-sm-8 col-sm-offset-2 col-md-7 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="panel-body">
                <div class="text-center">
                    <img style="margin-bottom:10px" height="150" alt="Veralux-Promet d.o.o." src="/images/veralux-promet.svg">
                </div>
                @if (session('success'))
                    <br>
                    <div class="alert alert-info">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('warning'))
                    <br>
                    <div class="alert alert-info">
                        {{ session('warning') }}
                    </div>
                @endif
                <form class="logForm" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>E-mail adresa</label>
                        <input type="email" class="form-control" placeholder="E-mail adresa" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>Lozinka</label>
                        <input type="password" class="form-control" placeholder="Lozinka" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="checkbox">
                         <label for="remember">
                            <input type="checkbox" name="remember" id="remember">
                             Zapamti moju prijavu
                         </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="glyphicon glyphicon-log-in"></i><span style="margin-left:5px">&nbsp;Prijava</span>
                    </button><br>
                    <div class="form-group">
                        <p><a href="{{ url('/password/reset') }}">Zaboravili ste lozinku?</a></p>
                        <p><a href="{{ url('/email-verification-resend') }}">Ponovno slanje aktivacijske poveznice</a></p>
                    </div>
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
    {{-- include icheck plugin // customized checkboxes and radio buttons   --}}
    <script type="text/javascript" src="/assets/plugins/icheck-1.x/icheck.min.js"></script>
@endsection