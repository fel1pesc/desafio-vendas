<!doctype html>
<html>
<head>
    <meta charset="UTF-8">

    {{--Jquery--}}
    <script src="{{ asset('plugins/jquery/jquery-3.4.1.min.js') }}"></script>
    {{--Bootstrap--}}
    <link rel="stylesheet" href="{{ asset('bootstrap-4.5.0-dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap-4.5.0-dist/js/bootstrap.js') }}"></script>
    {{--Fontes/Icons--}}
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome-4.5.0/css/font-awesome.min.css') }}">
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert/sweetalert2.min.css') }}">
    <script type="text/javascript" src="{{ asset('/plugins/sweetalert/sweetalert2.min.js') }}"></script>
    {{--Preload Custom--}}
    <script type="text/javascript" src="{{ asset('/plugins/preload-custom/preload-custom.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/plugins/preload-custom/preload-custom.css') }}">

    <script type="text/javascript" src="{{ asset('js/helpers.js') }}"></script>

    <style>
        .navbar li a{
            color: white !important;
        }

        .navbar .active a{
            color: grey !important;
        }

        .navbar li a:hover{
            color: grey !important;
        }

        .navbar-nav form button:hover{
            color: grey !important;
        }
    </style>

    @yield('scripts-header')
</head>
<body>
    @yield('content')

    @yield('scripts-footer')

    <script type="text/javascript">
        var urlBase = '{{ url('') }}/';
        var _token = '{{csrf_token()}}';
    </script>

</body>
</html>