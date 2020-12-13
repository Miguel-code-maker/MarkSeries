<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <style>
        li {
            list-style: none;
        }

        .logo {
            font-size: 1.5rem;
        }

        .label__check {
            transform: translateY(-5px);
        }

    </style>
    @yield('heade')
    <title>@yield('titleDocument')</title>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2 d-flex justify-content-between">
        <a class="navbar navbar-expand-lg font-weight-bold logo" href="{{ route('series') }}">Home</a>
        @auth
            <a href="/logout" class="text-danger">Sair</a>
        @endauth
        @guest
            <a href="/login" class="text-danger">Entrar</a>
        @endguest
    </nav>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">@yield('title')</h1>
        </div>
        @yield('content')
    </div>

    @yield('javaScript')
</body>
</html>
