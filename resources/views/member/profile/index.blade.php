@extends('admin.layout')

@section('style')
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/pages/profile.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/v1.css')}}">
<link rel="stylesheet" href="{{asset('app/material/base/assets/examples/css/dashboard/ecommerce.css')}}">
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/chartist/chartist.css')}}">
@endsection

@section('page_header')
Profile
@endsection

@section('body-class')
page-profile
@endsection

@section('content')
    @php
        $dashboard = dashboardcontent(auth()->user()->id);
    @endphp
    
    @include('member.account-activation.modal.activate')
    @if(Session::has('error'))
    <div class="col-lg-12">
      <div class="alert dark alert-icon alert-primary alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="icon md-money-off" aria-hidden="true"></i> {{ Session::get('error') }}
      </div>
    </div>
    @endif 
    <div class="col-lg-4 p-0">
      <div class="col-lg-12">
        <div class="card card-shadow text-center">
          <div class="card-block pb-4 pt-4">
            <a class="avatar avatar-lg bg-gray" href="javascript:void(0)">
              <img src="{{auth()->user()->prof_img}}" alt="...">
            </a>
          
            <h4 class="profile-user">{{auth()->user()->name}}</h4>
            <h6 class="profile-user_type">{{strtoupper(auth()->user()->position)}}</h6>
            @if(!empty(auth()->user()->subscription()->first()) && !empty(auth()->user()->subscription()->where('valid', 1)->where('status', 1)->first()))
              <span class="badge badge-lg badge-success">Active</span>

              <p class="pt-4 mb-2">MEMBER SINCE {{auth()->user()->created_at->format('M d, Y')}}</p>

              <button type="button" class="btn btn-info waves-effect waves-classic" data-toggle="modal" data-target="#activateAccountModal">Add Capital</button>
            @elseif(!empty(auth()->user()->subscription()->first()) && !empty(auth()->user()->subscription()->where('valid', 1)->where('status', 0)->first()))
              <span class="badge badge-lg badge-primary">Pending Activation</span>  

            @elseif(!empty(auth()->user()->subscription()->first()) && empty(auth()->user()->subscription()->where('valid', 1)->first()))
              <span class="badge badge-lg badge-warning">Expired</span>

              <p class="pt-4 mb-2">MEMBER SINCE {{auth()->user()->created_at->format('M d, Y')}}</p>
            @else 
              <span class="badge badge-lg badge-default">Inactive</span>

              <div class="profile-social">
              
              </div>
              
              <button type="button" class="btn btn-info waves-effect waves-classic" data-toggle="modal" data-target="#activateAccountModal">Activate Account</button>
            @endif

          </div>
          <div class="card-footer">
            <div class="row no-space">
              <div class="col-6">
                <strong class="profile-stat-count">{{number_format(auth()->user()->wallet_balance, 2, '.', ',')}}</strong>
                <span>Wallet Balance</span>
              </div>
              <div class="col-6">
                <strong class="profile-stat-count">{{!empty($dashboard->capital) ? number_format($dashboard->capital->sum('amount'), 2, '.', ',') : 0}}</strong>
                <span>Total Capital</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>    
    
    <div class="col-lg-8 row">
        <div class="col-md-6">
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

        <div class="col-md-6">
          <div class="card card-shadow">
            <div class="card-block bg-white p-20">
              <button type="button" class="btn btn-floating btn-sm btn-primary">
                <i class="icon fa-dollar"></i>
                  </button>
                  <span class="ml-15 font-weight-400">EARNINGS</span>
                  <div class="content-text text-center mb-0">
                    <i class="text-danger icon ti-triangle-up font-size-20">
                </i>
                <span class="font-size-40 font-weight-100">{{!empty($dashboard->earnings) ? number_format($dashboard->earnings->sum('amount'), 2, '.', ',') : 0}}</span>
                <p class="blue-grey-400 font-weight-100 m-0">Last month earnings {{!empty(monthlyRecords('earnings', auth()->user()->id)->last->first()) ? number_format(monthlyRecords('earnings', auth()->user()->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card card-shadow">
            <div class="card-block bg-white p-20">
              <button type="button" class="btn btn-floating btn-sm btn-success">
                <i class="fa-sign-in"></i>
                  </button>
                  <span class="ml-15 font-weight-400">CASH-IN</span>
                  <div class="content-text text-center mb-0">
                    <i class="text-danger icon ti-triangle-up font-size-20">
                </i>
                <span class="font-size-40 font-weight-100">{{!empty($dashboard->cashin) ? number_format($dashboard->cashin->sum('amount'), 2, '.', ',') : 0}}</span>
                <p class="blue-grey-400 font-weight-100 m-0">Last month cashin total {{!empty(monthlyRecords('cashin', auth()->user()->id)->last->first()) ? number_format(monthlyRecords('cashin', auth()->user()->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card card-shadow">
            <div class="card-block bg-white p-20">
              <button type="button" class="btn btn-floating btn-sm btn-warning">
                <i class="fa-sign-out"></i>
                  </button>
                  <span class="ml-15 font-weight-400">CASH-OUT</span>
                  <div class="content-text text-center mb-0">
                    <i class="text-danger icon ti-triangle-up font-size-20">
                </i>
                <span class="font-size-40 font-weight-100">{{!empty($dashboard->cashout) ? number_format($dashboard->cashout->sum('amount'), 2, '.', ',') : 0}}</span>
                <p class="blue-grey-400 font-weight-100 m-0">Last month cashout total {{!empty(monthlyRecords('cashout', auth()->user()->id)->last->first()) ? number_format(monthlyRecords('cashout', auth()->user()->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
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
    </div>

    <!-- <div class="col-lg-12 mt-4 pt-4">
      <h1 class="page-title py-4 my-2">Daily Login Bonus</h1>
      <div class="card card-shadow">
        <div class="card-block bg-white p-20">
          @include('content.daily-login-bonus')
        </div>
      </div>
    </div> -->
@endsection

@push('scripts')
<script src="{{asset('app/classic/global/vendor/chartist/chartist.min.js')}}"></script>
<script src="{{asset('assets/js/profile.js')}}"></script>
<script>
    window.loginBonusURL = '{!! url("res/login-bonus") !!}';
</script>
<script src="{{asset('assets/js/login-bonus.js')}}"></script>
@endpush        