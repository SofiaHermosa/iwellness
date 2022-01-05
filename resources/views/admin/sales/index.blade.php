@extends('admin.layout')

@section('style')
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/pages/profile.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/v1.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/ecommerce.css')}}">
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/chartist/chartist.css')}}">
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endsection

@section('page_title')
<div class="page-header">
    <div class="row">
        <div class="col-md-9">
            <h1 class="page-title">Sales Analytics</h1>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon wb-calendar" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control date-filter" data-plugin="datepicker">
            </div>
        </div>
    </div>
</div>
@endsection

@section('body-class')
page-profile
@endsection

@section('content')
<div id="supervisor_sales" class="w-full row">
    <div class="page-content w-full mt-4 pt-4 text-center vertical-align-middle">
        <i class="icon fa-spinner icon-spin page-maintenance-icon font-size-60" aria-hidden="true"></i>
        <h2>Loading analytics.....</h2>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.sales_url = '{!! url("res/sales") !!}';
</script>
<script src="{{asset('app/classic/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/sales.js')}}"></script>
@endpush        