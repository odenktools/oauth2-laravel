<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>@yield('title'){{ trans('app.title') }}</title>

    @include('layouts.styles')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        (function () {
            window.config = window.config || {};
            window.config = JSON.parse('{!! json_encode($config) !!}');
        })();
    </script>
</head>
<body @yield('body-class')>
    <div id="preloader">
        <span class="spinner"></span>
    </div>

    <div class="wrapper">
        @yield('wrapper')
    </div>

    @include('layouts.scripts')
</body>
</html>
