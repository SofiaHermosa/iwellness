@extends('admin.layout')

@section('page_header')
Activity Logs
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
            <h1 class="page-title">Activity Logs</h1>
        </div>

        <div class="col-md-4 text-right">
            @if(!empty(auth()->user()->subscription()->first()) && !empty(auth()->user()->subscription()->where('valid', 1)->where('status', 1)->first()))
              <span class="badge badge-lg badge-success vertical-align-middle font-size-20">Active</span>
            @elseif(!empty(auth()->user()->subscription()->first()) && !empty(auth()->user()->subscription()->where('valid', 1)->where('status', 0)->first()))
              <span class="badge badge-lg badge-primary vertical-align-middle font-size-20">Pending Activation</span>  
            @elseif(!empty(auth()->user()->subscription()->first()) && empty(auth()->user()->subscription()->where('valid', 1)->first()))
              <span class="badge badge-lg badge-warning vertical-align-middle font-size-20">Expired</span>
            @else 
              <span class="badge badge-lg badge-default vertical-align-middle font-size-20">Inactive</span>
            @endif
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            @include('member.activity.table.activity')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.url = "{!! url('res/activity/logs') !!}";
    window.table = "#activityDataTable";
</script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/dropify/dropify.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/activity.js')}}"></script>
@endpush        