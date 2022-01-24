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
        <div class="col-md-4">
            <button class="btn btn-tagged social-linkedin float-right request--btn" data-modal="#cashinModal">
                <span class="btn-tag"><i class="icon fa-sign-in" aria-hidden="true"></i></span>
                <span class="btn--text">Cash-In</span>
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('member.manage-funds.modal.cash-in')
@include('member.manage-funds.modal.cash-out')
@include('member.manage-funds.modal.cash-in-status')
@include('member.manage-funds.modal.cash-out-status')
@include('member.account-activation.modal.activate')
<div class="col-lg-12 px-0">
    <div class="col-lg-2 col-sm-6 float-right">
        <div class="form-group">
            <select class="form-control filter" data-sec="status">
                <option value="" disabled selected>Filter by Status</option>
                <option value="0">Pending</option>
                <option value="1">Approved</option>
                <option value="2">Declined</option>
            </select>
        </div>
    </div>

    <div class="col-lg-2 col-sm-6 float-right">
        <div class="form-group">
            <select class="form-control filter" data-sec="mop">
                <option value="" disabled selected>Filter by MOP</option>
                @foreach (config('constants.cashout_mode_of_payment') as $key => $mop)
                <option value="{{$mop}}">{{$mop}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@if(Session::has('invalid_ref_no'))
<div class="col-lg-12">
    <div class="alert dark alert-icon alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="icon md-alert-triangle" aria-hidden="true"></i> {{ Session::get('invalid_ref_no') }}
    </div>
</div>
@endif  
<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="example-wrap m-xl-0">
                <div class="nav-tabs-horizontal" data-plugin="tabs">
                    <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" data-action="{{empty(auth()->user()->subscription()->first()) && empty(auth()->user()->subscription()->where('valid', 1)->where('status', 1)->first()) ? 'Activate Account': 'Add Capital'}}" href="#subscriptionTab" aria-controls="subscriptionTab" role="tab" aria-selected="true">Capital</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link active show" data-action="Cash-in" data-toggle="tab" href="#exampleTabsLineOne" aria-controls="exampleTabsLineOne" role="tab" aria-selected="false">Cash-in</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-action="{{auth()->user()->is_active ? 'Cash-out' : 'disabled'}}" data-toggle="{{auth()->user()->is_active ? 'tab' : 'disabled'}}" href="{{auth()->user()->is_active ? '#exampleTabsLineTwo' : 'javascript:void(0)'}}" aria-controls="exampleTabsLineTwo" role="tab" aria-selected="true" {{auth()->user()->is_active ? '' : 'disabled'}}>Cash-out</a></li>
                        <li class="dropdown nav-item" role="presentation" style="display: none;">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-expanded="false">Dropdown </a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" data-action="{{auth()->user()->is_active ? 'Cash-out' : 'disabled'}}" data-toggle="{{auth()->user()->is_active ? 'tab' : 'disabled'}}" href="{{auth()->user()->is_active ? '#exampleTabsLineTwo' : 'javascript:void(0)'}}" aria-controls="exampleTabsLineTwo" role="tab" aria-selected="true" {{auth()->user()->is_active ? '' : 'disabled'}} aria-controls="exampleTabsLineOne" role="tab">Cash-in</a>
                            <a class="dropdown-item" data-toggle="tab" data-action="Cash-out" href="#exampleTabsLineTwo" aria-controls="exampleTabsLineTwo" role="tab">Cash-out</a>
                            <a class="dropdown-item" data-toggle="tab" data-action="{{empty(auth()->user()->subscription()->first()) && empty(auth()->user()->subscription()->where('valid', 1)->where('status', 1)->first()) ? 'Activate Account': 'Add Capital'}}" href="#subscriptionTab" aria-controls="subscriptionTab" role="tab">Capital</a>
                        </div>
                        </li>
                    </ul>
                    <div class="tab-content pt-20">
                        <div class="tab-pane" id="subscriptionTab" role="tabpanel">
                            @include('member.manage-funds.table.subscriptions')
                        </div>
                        <div class="tab-pane active show" id="exampleTabsLineOne" role="tabpanel">
                            @include('member.manage-funds.table.cash-in')
                        </div>

                        @if(auth()->user()->hasanyrole('member|team leader|manager'))
                        <div class="tab-pane" id="exampleTabsLineTwo" role="tabpanel">
                            @include('member.manage-funds.table.cash-out')
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.url           = "{!! url('res/manage-funds/') !!}";
    window.subscriptions = "{!! url('res/subscriptions/') !!}";
</script>

<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/dropify/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/manage-funds.js')}}"></script>
@endpush        