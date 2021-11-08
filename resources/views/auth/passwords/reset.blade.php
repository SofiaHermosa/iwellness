@extends('auth.layout')

@section('page_title')
Forgot Password
@endsection

@section('content')
@if(!empty(retriveAccountData(request()->email)))
<form method="POST" action="{{ url('retrive/account') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" class="form-control" id="inputEmail" name="email" value="{{ old('email') ?? request()->email }}" required>
    <input type="hidden" class="form-control @error('username') is-valid @enderror" value="{{ retriveAccountData(request()->email)->username }}" required autocomplete="username" name="username">
    
    <div class="col-lg-12 p-20 text-center">
        <a class="avatar avatar-lg bg-gray ml-0" style="max-width: 15vh !important;width: 15vh !important;" href="javascript:void(0)">
            <img src="{{asset('assets/images/default-profile.jpg')}}" alt="...">
        </a>
        <h4 class="profile-user text-center">{{retriveAccountData(request()->email)->name}}</h4>
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
        <input type="text" class="form-control form-control-lg" name="answer" value="{{ old('answer') }}" required>
        <label class="floating-label" for="inputEmail">{{config('constants.questions.'.json_decode(retriveAccountData(request()->email)->secret_question)->question)}}</label>

        @error('answer')
            <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="answer" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Proceed') }}
    </button>
</form>
@if (Session::has('error'))
<div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="icon md-alert-circle-o" aria-hidden="true"></i> {!! Session::get('error') !!}
</div>
@endif
@else
    <div class="col-lg-12 text-center p-20 mt-80">
        <i class="icon md-alert-circle-o font-size-60 text-danger" aria-hidden="true"></i><br>
        <p class="font-size-20">Invalid forget password token.</p>

    </div>
@endif
@endsection
