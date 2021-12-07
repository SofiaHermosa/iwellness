@extends('admin.layout')

@section('page_header')
Transaction History
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
        <div class="col-md-12">
            <h1 class="page-title">Transaction History</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            @include('member.logs.table.logs')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.url = "{!! url('res/logs/history') !!}";
    window.table = "#logsDataTable";
</script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/dropify/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/logs.js')}}"></script>
@endpush        