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
    <style>
        body{
            background: #313232 !important;
        }
    </style>
    <title>Survey</title>
</head>
<body>
    @include('member.account-activation.modal.activate')
    <div class="container">
        @if(auth()->user()->is_active)
            <div class="row">
            <div class="col-lg-12 px-10 mt-40 d-flex justify-content-center">
                <img src="{{asset('assets/images/iwellness_logo_text.png')}}" width="15%" class="m-auto" alt="">
            </div>
            <div class="col-lg-12 px-60 mt-60">
                <div class="w-full text-center">
                    <i class="icon md-check-circle text-success animation-slide-top" style="font-size: 5rem !important;"></i><br/>
                    <h1 class="font-size-30 animation-slide-bottom text-white">Your done with the survey, pls come back next cut off.</h1>
                    @if(isset($next))
                        <a href="{{url('res/survey/'.base64_encode(auth()->user()->id))}}" class="btn btn-dark btn-lg mt-40 animation-fade">
                            {{$next}}
                        </a>
                    @else
                        <a href="javascript:void(0)" onclick="{{$back}}" class="btn btn-dark btn-lg mt-40 animation-fade">
                            Back
                        </a>
                    @endif  
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-12 px-10 mt-40 d-flex justify-content-center">
                <img src="{{asset('assets/images/iwellness_logo_text.png')}}" width="15%" class="m-auto" alt="">
            </div>
            <div class="col-lg-12 px-60 mt-60">
                <div class="w-full text-center">
                    <i class="icon md-alert-circle text-success animation-slide-top" style="font-size: 5rem !important;"></i><br/>
                    <h1 class="font-size-30 animation-slide-bottom text-white">Can't proceed with the survey you need activate/re-activate your account.</h1>
                        <button data-toggle="modal" data-target="#activateAccountModal" class="btn btn-dark btn-lg mt-40 animation-fade">
                            Activate Account
                        </button> 
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
<script src="{{asset('app/classic/global/vendor/jquery/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="{{asset('app/classic/global/vendor/bootstrap/bootstrap.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/animsition/animsition.js')}}"></script>
<script src="{{asset('assets/js/profile.js')}}"></script>
</html>