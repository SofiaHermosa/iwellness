@extends('admin.layout')

@section('body-class')
page-profile
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/pages/profile.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/v1.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/ecommerce.css')}}">
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/chartist/chartist.css')}}">
@endsection

@section('page_title')
<div class="page-header">
    <h1 class="page-title">{{!empty($user) ? ucwords($user->username) : 'New User'}}</h1>
</div>
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body container-fluid">
                @include('layouts.alert')
                <form action="{{empty($user) ? url('res/users') : url('res/users/'.$user->id)}}" method="POST" class="row" id="{{!empty($user) ? 'updateUserForm' : 'createUserForm'}}">
                    @csrf
                    @if (!empty($user))
                        {{ method_field('PUT') }}
                    @endif
                    <input type="hidden" name="id" value="{{$user->id ?? ''}}">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" value="{{$user->name ?? old('name')}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" value="{{$user->username ?? old('username')}}" class="form-control">
                        </div>
                    </div>

                   

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" value="{{$user->email ?? old('email')}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Contact No.</label>
                            <input type="text" name="contact" value="{{$user->contact ?? old('contact')}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Position</label>
                            <select name="position" class="form-control">
                                <option value=""></option>
                                @foreach (config('constants.user_type') as $position)
                                    <option value="{{$position}}" {{!empty(old('position')) ? (old('position') == $position ? 'selected' : '') : ''}} {{!empty($user) ? ($user->hasanyrole($position) ? 'selected' : '') : '' }}>{{ucwords($position)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Secret Question</label>
                            <select name="secret_question[question]" class="form-control">
                                <option value=""></option>
                                @foreach (config('constants.questions') as $key => $question)
                                  <option value="{{$key}}" {{!empty(old('secret_question.question')) ?  (old('secret_question.question') == $key ? 'selected' : '') : ''}}  {{!empty($user) ? ($user->secret_question->question == $key ? 'selected' : '') : '' }}>{{$question}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Answer</label>
                            <input type="text" name="secret_question[answer]" value="{{$user->secret_question->answer ?? old('secret_question.answer')}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        @if (!empty($user))
                            <button type="button" class="btn btn-danger btn--archive" data-form="#deleteUserForm">Archive</button>
                        @endif
                        
                        <button class="btn btn-info">Save</button>
                    </div>
                </form>

                @if (!empty($product))
                    <form method="POST" action="{{url('res/users/'.$product->id)}}" id="deleteUserForm">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                @endif
            </div>
        </div>
    </div>
    @if(!empty($user))
        @include('admin.components.user-details')    
    @endif
@endsection

@push('scripts')
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/users.js')}}"></script>
@endpush 