@extends('admin.layout')

@section('style')
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/v1.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/ecommerce.css')}}">
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/chartist/chartist.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/widgets/chart.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-chart.css')}}">
@endsection

@section('page_header')
Dashboard
@endsection

@section('body-class')
page-dashboard
@endsection

@section('content')
@php
$dashboard = dashboardcontent();
@endphp
<div id="fundData" data-funds="{{base64_encode(json_encode(dashboardChart()->fundChart))}}"></div>
<div id="CashinData" 
data-pending="{{base64_encode(!empty($dashboard->cashin) ? $dashboard->cashin->where('status', 0)->sum('amount') : 0)}}"
data-approved="{{base64_encode(!empty($dashboard->cashin) ? $dashboard->cashin->where('status', 1)->sum('amount') : 0)}}"
data-declined="{{base64_encode(!empty($dashboard->cashin) ? $dashboard->cashin->where('status', 2)->sum('amount') : 0)}}"
></div>
<div id="CashoutData" 
data-pending="{{base64_encode(!empty($dashboard->cashout) ? $dashboard->cashout->where('status', 0)->sum('amount') : 0)}}"
data-approved="{{base64_encode(!empty($dashboard->cashout) ? $dashboard->cashout->where('status', 1)->sum('amount') : 0)}}"
data-declined="{{base64_encode(!empty($dashboard->cashout) ? $dashboard->cashout->where('status', 2)->sum('amount') : 0)}}"
></div>

<div class="col-md-4">
  <div class="card card-shadow">
    <div class="card-block bg-white p-20">
      <button type="button" class="btn btn-floating btn-sm btn-primary">
        <i class="icon fa-dollar"></i>
          </button>
          <span class="ml-15 font-weight-400">COMMISIONS</span>
          <div class="content-text text-center mb-0">
            <i class="text-danger icon ti-triangle-up font-size-20">
        </i>
        <span class="font-size-40 font-weight-100">{{!empty($dashboard->commissions) ? number_format($dashboard->commissions->sum('amount'), 2, '.', ',') : 0}}</span>
        <p class="blue-grey-400 font-weight-100 m-0">Last month commissions {{!empty(monthlyRecords('commissions', auth()->user()->id)->last->first()) ? number_format(monthlyRecords('commissions', auth()->user()->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
      </div>
    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card card-shadow">
    <div class="card-block bg-white p-20">
      <button type="button" class="btn btn-floating btn-sm btn-info">
        <i class="fa-diamond"></i>
          </button>
          <span class="ml-15 font-weight-400">DIAMONDS</span>
          <div class="content-text text-center mb-0">
            <i class="text-danger icon fa-triangle-up font-size-20">
        </i>
        <span class="font-size-40 font-weight-100">{{!empty($dashboard->diamonds) ? number_format($dashboard->diamonds->sum('amount'), 2, '.', ',') : 0}}</span>
        <p class="blue-grey-400 font-weight-100 m-0">Last month diamonds {{!empty(monthlyRecords('diamonds', auth()->user()->id)->last->first()) ? number_format(monthlyRecords('diamonds', auth()->user()->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
      </div>
    </div>
  </div>
</div>


<div class="col-lg-12 no-space p-0">
  <div class="col-lg-12">
    <div class="card card-shadow example-responsive" id="fundRequestChart">
      <div class="card-block p-30" style="min-width:480px;">
        <div class="row pb-20" style="height:calc(100% - 322px);">
          <div class="col-md-3 col-sm-6">
            <div class="blue-grey-700">FUND REQUEST</div>
          </div>
          <div class="col-md-9 col-sm-6">
            <div class="row">
              <div class="col-sm-6">
                <div class="counter counter-md">
                  <div class="counter-number-group text-nowrap">
                    <span class="counter-number">{{!empty($dashboard->cashin) ? number_format($dashboard->cashin->sum('amount'), 2, '.', ',') : 0}}</span>
                  </div>
                  <div class="counter-label blue-grey-400">Cash-in</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="counter counter-md">
                  <div class="counter-number-group text-nowrap">
                    <span class="counter-number">{{!empty($dashboard->cashout) ? number_format($dashboard->cashout->sum('amount'), 2, '.', ',') : 0}}</span>
                  </div>
                  <div class="counter-label blue-grey-400">Cash-out</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="ct-chart mb-30" style="height:270px;">
        </div>
        <ul class="list-inline text-center pt-25 h-50">
          <li class="list-inline-item  mx-15">
            <i class="icon wb-large-point blue-200 mr-10" aria-hidden="true"></i> 
            CASH-IN
          </li>
          <li class="list-inline-item mx-15">
            <i class="icon wb-large-point teal-200 mr-10" aria-hidden="true"></i>  
            CASH-OUT
          </li>
        </ul>
    </div>
  </div>
</div>

<div class="row p-2">
  <div class="col-lg-6">
    <div class="card card-shadow" id="chartPieCashin">
      <div class="card-block p-0 p-30 h-full">
        <div class="font-size-20 text-center" style="height:calc(100% - 350px);">
          Cash-in Summary
        </div>
        <div class="ct-chart h-250 pt-40">
  
        </div>
        <div class="row no-space mt-20">
          <div class="col-4">
            <div class="counter">
              <div class="counter-number-group font-size-14">
                <span class="counter-number-related">
                  <span class="icon wb-medium-point green-600"></span>
                </span>
                <span class="counter-cashin-pending font-size-24">35%</span><br>
                <span class="counter-number-related font-size-14">
                  {{number_format(!empty($dashboard->cashin) ? $dashboard->cashin->where('status', 0)->sum('amount') : 0, 2, '.', ',')}}
                </span>
              </div>
              <div class="counter-label text-uppercase">PENDING</div>
            </div>
          </div>
          <div class="col-4">
            <div class="counter">
              <div class="counter-number-group font-size-14">
                <span class="counter-number-related">
                  <span class="icon wb-medium-point blue-600"></span>
                </span>
                <span class="counter-cashin-approved font-size-24">20%</span><br>
                <span class="counter-number-related font-size-14">
                  {{number_format(!empty($dashboard->cashin) ? $dashboard->cashin->where('status', 1)->sum('amount') : 0, 2, '.', ',')}}
                </span>
              </div>
              <div class="counter-label text-uppercase">APPROVED</div>
            </div>
          </div>
          <div class="col-4">
            <div class="counter text-center">
              <div class="counter-number-group font-size-14">
                <span class="counter-number-related">
                  <span class="icon wb-medium-point red-600"></span>
                </span>
                <span class="counter-cashin-declined font-size-24">45%</span><br>
                <span class="counter-number-related font-size-14">
                  {{number_format(!empty($dashboard->cashin) ? $dashboard->cashin->where('status', 2)->sum('amount') : 0, 2, '.', ',')}}
                </span>
              </div>
              <div class="counter-label text-uppercase">DECLINED</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-6">
    <div class="card card-shadow" id="chartPieCashout">
      <div class="card-block p-0 p-30 h-full">
        <div class="font-size-20 text-center" style="height:calc(100% - 350px);">
          Cash-out Summary
        </div>
        <div class="ct-chart h-250 pt-40">
  
        </div>
        <div class="row no-space mt-20">
          <div class="col-4">
            <div class="counter">
              <div class="counter-number-group font-size-14">
                <span class="counter-number-related">
                  <span class="icon wb-medium-point green-600"></span>
                </span>
                <span class="counter-cashout-pending font-size-24">35%</span><br>
                <span class="counter-number-related font-size-14">
                  {{number_format(!empty($dashboard->cashout) ? $dashboard->cashout->where('status', 0)->sum('amount') : 0, 2, '.', ',')}}
                </span>
              </div>
              <div class="counter-label text-uppercase">PENDING</div>
            </div>
          </div>
          <div class="col-4">
            <div class="counter">
              <div class="counter-number-group font-size-14">
                <span class="counter-number-related">
                  <span class="icon wb-medium-point blue-600"></span>
                </span>
                <span class="counter-cashout-approved font-size-24">20%</span><br>
                <span class="counter-number-related font-size-14">
                  {{number_format(!empty($dashboard->cashout) ? $dashboard->cashout->where('status', 1)->sum('amount') : 0, 2, '.', ',')}}
                </span>
              </div>
              <div class="counter-label text-uppercase">APPROVED</div>
            </div>
          </div>
          <div class="col-4">
            <div class="counter text-center">
              <div class="counter-number-group font-size-14">
                <span class="counter-number-related">
                  <span class="icon wb-medium-point red-600"></span>
                </span>
                <span class="counter-cashout-declined font-size-24">45%</span><br>
                <span class="counter-number-related font-size-14">
                  {{number_format(!empty($dashboard->cashout) ? $dashboard->cashout->where('status', 2)->sum('amount') : 0, 2, '.', ',')}}
                </span>
              </div>
              <div class="counter-label text-uppercase">DECLINED</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('app/classic/global/vendor/chartist/chartist.min.js')}}"></script>
<script src="{{asset('assets/js/chart.js')}}"></script>
@endpush