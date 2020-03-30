<!-- Global -->
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/{{ config('asset.css') }}/fonts.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/{{ config('asset.plugins') }}/jquery-ui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/{{ config('asset.plugins') }}/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/{{ config('asset.plugins') }}/font-awesome/4.7.0/css/font-awesome.min.css">
@yield('styles')
@stack('styles')
