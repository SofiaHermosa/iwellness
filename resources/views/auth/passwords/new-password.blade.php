@extends('auth.layout')

@section('page_title')
New Password
@endsection

@section('content')
<form method="POST" action="{{ url('verify/new/password') }}" id="verifyNewPassForm" class="pt-40">
    @csrf
    <div class="input-group form-material floating" data-plugin="formMaterial">
        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
        <label class="floating-label" for="inputEmail">New Password</label>

        <span class="input-group-btn input-group-append pl-1">
            <button class="btn btn-link btn-icon py-2 showPass" type="button"><i class="pass-icon icon fa-eye"></i></button>
        </span>
        @error('password')
            <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="email" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="input-group form-material floating" data-plugin="formMaterial">
        <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
        <label class="floating-label" for="inputEmail">Confirm Password</label>

        <span class="input-group-btn input-group-append pl-1">
            <button class="btn btn-link btn-icon py-2 showPass" type="button"><i class="pass-icon icon fa-eye"></i></button>
        </span>
        @error('password_confirmation')
            <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="email" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Save') }}
    </button>
</form>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
               
@endsection
