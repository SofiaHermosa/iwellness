@extends('admin.layout')

@section('page_header')
Survey
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/dropify/dropify.css')}}">
@endsection

@section('page_title')
<div class="page-header">
    <h1 class="page-title">{{!empty($survey) ? 'Edit' : 'New'}} Survey</h1>
</div>
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body container-fluid">
                @include('layouts.alert')
                <form action="{{empty($survey) ? url('res/survey') : url('res/products/'.$survey->id)}}" class="row" method="POST" enctype="multipart/form-data">
                    <div id="surveyBuilder" class="col-lg-12"></div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
<script src="{{asset('assets/js/survey.js')}}"></script>
@endpush 