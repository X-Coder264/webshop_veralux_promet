<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Veralux-promet d.o.o.</title>

    <!-- Styles -->
    {{-- Bootstrap core CSS --}}
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">

    {{-- Custom styles for this template --}}
    <link rel="stylesheet" href="/assets/css/style.min.css">

    {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
    <script src="/assets/js/libs/html5shiv/html5shiv.min.js"></script>
    <script src="/assets/js/libs/respond/respond.min.js"></script>
    <![endif]-->

    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>

</head>
<body>

{{$user->name}}
{{$user->city}}
<div>Narudžba #{{$order->id}}</div>

<table>
    <thead>
    <tr>
        <td>Ime</td>
        <td>Količina</td>
    </tr>
    </thead>
    <tbody>
    @foreach($user->cart->cartProducts as $cartProduct)
        <tr>
        <td>{{$cartProduct->product->name}}</td>
        <td>{{$cartProduct->quantity}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>