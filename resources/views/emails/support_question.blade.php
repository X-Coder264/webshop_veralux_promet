<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <title>Veralux-Promet d.o.o.</title>

    <meta name="apple-mobile-web-app-title" content="Veralux-Promet d.o.o.">
    <meta name="application-name" content="Veralux-Promet d.o.o.">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

Ime korisnika: {{ $requestData['sender_name'] }} <br>
Email korisnika: {{ $requestData['sender_email'] }} <br>

Pismo:

{{ $requestData['message'] }} <br>

</body>
</html>