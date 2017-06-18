<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <title>Veralux-Promet d.o.o.</title>

    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">

    {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/libs/html5shiv/html5shiv.min.js')}}"></script>
    <script src="{{asset('assets/js/libs/respond/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body>

Reset Password

{{ url(config('app.url').route('password.reset', $token, false)) }}

<script type="text/javascript" src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>

</body>
</html>