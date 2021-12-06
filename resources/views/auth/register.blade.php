@extends('auth.layout')

@section('page_title')
Sign Up
@endsection

@section('content')
@include('auth.modal.terms-condition')

<form method="post" role="form" action="{{ route('register') }}" id="createUserForm" autocomplete="off">
    @csrf
   
    @if(Session::has('message'))
    <div class="alert dark alert-icon alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="icon md-check" aria-hidden="true"></i> {!! Session::get('message') !!}
    </div>
    @endif 
    
    <div class="form-group form-material floating" data-plugin="formMaterial">
      <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name') }}" required>
      <label class="floating-label" for="inputName">Name</label>

      @error('name')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="name" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
      <input type="email" class="form-control" id="inputEmail" name="email" value="{{ old('email') }}" required>
      <label class="floating-label" for="inputEmail">Email</label>

      @error('email')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="email" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
       <input type="text" class="form-control" id="inputContact" name="contact" value="{{ old('contact') }}" required>
       <label class="floating-label" for="inputContact">Contact No</label>

        @error('contact')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="contact" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
        <input type="text" class="form-control" id="inputUsername" name="username" value="{{ old('username') }}" required>
        <label class="floating-label" for="inputUsername">Username</label>

        @error('username')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="username" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
      <input type="password" class="form-control" id="password" name="password" required>
      <label class="floating-label" for="inputPassword">Password</label>

        @error('password')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="password" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group form-material floating" data-plugin="formMaterial">
      <input type="password" class="form-control" id="inputPasswordCheck" name="password_confirmation" required>
      <label class="floating-label" for="inputPasswordCheck">Retype Password</label>

        @error('password_confirmation')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="confirm_password" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
        <select class="form-control" id="inputQuestion" name="secret_question[question]" required>
            <option value=""></option>
            @foreach (config('constants.questions') as $key => $question)
              <option value="{{$key}}">{{$question}}</option>
            @endforeach
        </select>
        <label class="floating-label" for="inputQuestion">Secret Question</label>
        @error('secret_question.question')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="confirm_password" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
        <input type="password" class="form-control" id="inputAnswer" name="secret_question[answer]" value="{{ old('secret_question.answer') }}" required>
        <label class="floating-label" for="inputAnswer">Answer</label>

        @error('secret_question.answer')
            <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="confirm_password" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group form-material floating" data-plugin="formMaterial">
        <input type="text" class="form-control" id="inputReferrer" name="referer" value="{{isset(request()->referral) ? base64_decode(request()->referral) : ''}}"  {{isset(request()->referral) ? 'readonly="true"' : ''}}">
        <label class="floating-label" for="inputUsername">Referrer Username</label>

        @error('referer')
          <small class="invalid-feedback" data-fv-validator="notEmpty" data-fv-for="referer" data-fv-result="VALID" style="display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group clearfix">
      <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
        <input type="checkbox" id="inputCheckbox" name="term" value="true" required>
        <label for="inputCheckbox"></label>
      </div>
      <p class="ml-35">By clicking Sign Up, you agree to our Terms and Condition.</p>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
  </form>

  <p>Have account already? Please go to <a href="{{url('login')}}">Sign In</a></p>
@endsection

@push('script')

@endpush        