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
<div class="page-header">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title">Survey</h1>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            @include('admin.survey.table.survey')
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush        