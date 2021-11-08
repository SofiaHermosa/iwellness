<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <title>Document</title>

</head>
<body class="animsition">
  @include('guest.navbar')
  @yield('content')   
</body>
    <script src="{{asset('app/material/global/vendor/jquery/jquery.js')}}"></script>
</html>