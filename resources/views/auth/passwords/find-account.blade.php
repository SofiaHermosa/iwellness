@extends('auth.layout')

@section('page_title')
Forgot Password
@endsection

@section('content')
<form method="POST" action="{{ url('find/account') }}" class="pt-40">
    @csrf
    <div class="form-group form-material floating" data-plugin="formMaterial">
        <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
        <label class="floating-label" for="inputEmail">Username</label>

        @error('username')
            <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="email" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Find my Account') }}
    </button>
</form>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
               
@endsection
