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
            <h1 class="page-title">Manage Funds</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('admin.manage-funds.modal.cash-in')
@include('admin.manage-funds.modal.cash-out')
<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="example-wrap m-xl-0">
                <div class="nav-tabs-horizontal" data-plugin="tabs">
                    <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active show" data-action="Cash-in" data-toggle="tab" href="#exampleTabsLineOne" aria-controls="exampleTabsLineOne" role="tab" aria-selected="false">Cash-in</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-action="Cash-out" data-toggle="tab" href="#exampleTabsLineTwo" aria-controls="exampleTabsLineTwo" role="tab" aria-selected="true">Cash-out</a></li>
                        <li class="dropdown nav-item" role="presentation" style="display: none;">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-expanded="false">Dropdown </a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" data-toggle="tab" data-action="Cash-in" href="#exampleTabsLineOne" aria-controls="exampleTabsLineOne" role="tab">Cash-in</a>
                            <a class="dropdown-item" data-toggle="tab" data-action="Cash-out" href="#exampleTabsLineTwo" aria-controls="exampleTabsLineTwo" role="tab">Cash-out</a>
                        </div>
                        </li>
                    </ul>
                    <div class="tab-content pt-20">
                        <div class="tab-pane active show" id="exampleTabsLineOne" role="tabpanel">
                            @include('admin.manage-funds.table.cash-in')
                        </div>
                        <div class="tab-pane" id="exampleTabsLineTwo" role="tabpanel">
                            @include('admin.manage-funds.table.cash-out')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.cashin_url = "{!! url('res/fund-request?type=cashin') !!}";
    window.cashout_url = "{!! url('res/fund-request?type=cashout') !!}";
</script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('app/classic/global/vendor/dropify/dropify.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/funds-request.js')}}"></script>
@endpush        