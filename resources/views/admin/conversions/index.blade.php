@extends('admin.layout')

@section('page_header')
Manage Funds
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/dropify/dropify.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"/>
@endsection

@section('body-class')
page-profile
@endsection

@section('page_title')
<div class="page-header">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title">Diamond Conversion</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('admin.conversions.modal.details')
<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            @include('admin.conversions.table.request')
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.url = "{!! url('res/diamond/conversion/request') !!}";
</script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/conversion-request.js')}}"></script>
@endpush        