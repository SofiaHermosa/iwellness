@extends('auth.layout')

@section('page_title')
Sign In
@endsection

@section('content')
<form method="POST" action="{{ route('login') }}" autocomplete="new-password">
  @csrf

  @if($errors->first('inactive'))
  <div class="alert dark alert-icon alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
      </button>
      <i class="icon md-alert-circle-o" aria-hidden="true"></i> {!! $errors->first('inactive') !!}
  </div>
  @endif

  <div class="form-group form-material floating" data-plugin="formMaterial">
    <input type="text" class="form-control @error('username') is-valid @enderror" value="{{ old('username') }}" required autocomplete="username" autofocus name="username">
    <label class="floating-label" for="inputEmail">Username</label>

      @error('username')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="usrename" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
      @enderror
  </div>
  <div class="form-group form-material floating" data-plugin="formMaterial">
    <input type="password" class="form-control empty @error('password') is-valid @enderror" required autocomplete="current-password" id="inputPassword" name="password">
    <label class="floating-label" for="inputPassword">Password</label>

      @error('password')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="password" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
      @enderror
  </div>
  
  <div class="form-group clearfix">
    <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
      <input type="checkbox" id="remember" name="remember">
      <label for="inputCheckbox">Remember me</label>
    </div>
    <a class="float-right" target="_blank" href="{{ url('forget-password') }}">Forgot password?</a>
  </div>
  <button type="submit" class="btn btn-primary btn-block">Sign in</button>
</form>

<p>No account? <a href="{{url('register')}}">Sign Up</a></p>
@endsection

@push('script')

@endpush        