@extends('auth.layout')

@section('page_title')
Forgot Password
@endsection

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="col-lg-12 p-20 text-center">
        <a class="avatar avatar-lg bg-gray ml-0" style="max-width: 15vh !important;width: 15vh !important;" href="javascript:void(0)">
            <img src="{{asset('assets/images/default-profile.jpg')}}" alt="...">
        </a>
        <h4 class="profile-user text-center">{{$user->name}}</h4>
        <p>{{maskEmail($user->email)}}</p>
    </div>
    <input type="hidden" class="form-control" id="inputEmail" name="email" value="{{ $user->email }}" required>
    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Send Password Reset Link') }}
    </button>
</form>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
               
@endsection
