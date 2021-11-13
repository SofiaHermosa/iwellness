<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset('assets/images/iwellness_logo.png')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/css/bootstrap-extend.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/fonts/material-design/material-design.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/base/assets/css/site.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/animsition/animsition.css')}}">

    <title>Account Verification</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-60 mt-40">
                <div class="w-full text-center">
                    <i class="icon md-check-circle text-success animation-slide-top" style="font-size: 10rem !important;"></i><br/>
                    <h1 class="font-size-40 animation-slide-bottom">Account successfully confirmed.</h1>

                    <a href="{{url('login')}}" class="btn btn-default btn-lg mt-40 animation-fade">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{asset('app/classic/global/vendor/animsition/animsition.js')}}"></script>
</html>