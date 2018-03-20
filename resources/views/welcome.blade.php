<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        // rename myToken as you like
        window.myToken =  <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <title>{{ config('app.name', 'Bantam') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- for the inspinia theme -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}"  rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        [v-cloak]{
            display: none;
        }
    </style>

</head>
<body class="gray-bg">
<div id="app">


    <main class="py-4" v-cloak>
        @yield('content')
    </main>
</div>
<script src="js/jquery-3.1.1.min.js"></script>
<!-- Data picker -->
{{--<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>--}}
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

</body>
</html>
