<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CV - @yield('title')</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,700,700italic&subset=latin,vietnamese,latin-ext" media="screen" >
        <link rel="stylesheet" href="{{url('public/css/style.css')}}" media="screen">
        <link rel="stylesheet" href="{{url('public/css/bootstrap.min.css')}}" media="screen">
        <link rel="stylesheet" href="{{url('public/css/font-awesome.min.css')}}" media="screen">
    </head>
    <body>
        @yield('menu')
        @yield('content')
        <script src="{{url('public/js/jquery.min.js')}}"></script>
        <script src="{{url('public/js/bootstrap.min.js')}}"></script>
        <script src="{{url('public/js/functions.js')}}"></script>
        @yield('script')
    </body>
</html>
