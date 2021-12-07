@extends('admin.layout')

@section('page_header')
Survey
@endsection

@section('style')

@endsection

@section('body-class')
page-profile
@endsection

@section('page_title')
@include('admin.survey.module.create')
<div class="page-header">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title">Survey</h1>
        </div>
        <div class="col-md-4">
            <a href="javascript:void(0)" class="btn btn-tagged social-linkedin float-right" data-toggle="modal" data-target="#SurveyModal">
                <span class="btn-tag"><i class="icon md-plus" aria-hidden="true"></i></span>
                New Question
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">
    @include('layouts.alert')
</div>
<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            @include('admin.survey.table.survey')
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.url = "{!! url('res/survey') !!}";
</script>
<script src="{{asset('assets/js/survey.js')}}"></script>
@endpush        