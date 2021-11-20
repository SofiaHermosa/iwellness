<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" href="{{asset('app/classic/base/assets/images/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/iwellness_logo.png')}}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/summernote/summernote.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/alertify/alertify.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/base/assets/examples/css/tables/datatable.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom-guest.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/font-awesome/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/themify/themify.css')}}">
    
    <title>iWellness</title>

</head>
<body class="animsition">
  @include('guest.sections.cart')
  @yield('content')   
</body>
    <script src="{{asset('app/material/global/vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('app/material/global/vendor/bootstrap-sweetalert/sweetalert.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('app/classic/global/vendor/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('app/classic/global/vendor/alertify/alertify.js')}}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="text/javascript">
      AOS.init();
    </script>
    <script src="{{asset('assets/js/config.js')}}"></script>
    <script src="{{asset('assets/js/products.js')}}"></script>
    <script src="{{asset('assets/js/cart.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('assets/js/nav.js')}}"></script>

    @if(Session::has('error'))
    <script>
      alertify.error("{!! Session::get('error') !!}");
    </script>
    @endif
</html>