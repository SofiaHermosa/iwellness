@php
    $dashboard = dashboardcontent($user->id);
@endphp
<div class="col-lg-12 my-4">
    <h1 class="page-title">Other Details</h1>
</div>
<div class="col-md-4">
    <div class="card card-shadow">
    <div class="card-block bg-white p-20">
        <button type="button" class="btn btn-floating btn-sm btn-info">
        <i class="icon md-balance-wallet"></i>
            </button>
            <span class="ml-15 font-weight-400">WALLET</span>
            <div class="content-text text-center mb-0">
            <i class="text-danger icon ti-triangle-up font-size-20">
        </i>
        <span class="font-size-40 font-weight-100">{{number_format($user->wallet_balance, 2, '.', ',')}}</span>
        <p class="blue-grey-400 font-weight-100 m-0">Current total wallet balance</p>
        </div>
    </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card card-shadow">
    <div class="card-block bg-white p-20">
        <button type="button" class="btn btn-floating btn-sm btn-primary">
        <i class="icon fa-money"></i>
            </button>
            <span class="ml-15 font-weight-400">CAPITAL</span>
            <div class="content-text text-center mb-0">
            <i class="text-danger icon ti-triangle-up font-size-20">
        </i>
        <span class="font-size-40 font-weight-100">{{!empty($dashboard->capital) ? number_format($dashboard->capital->sum('amount'), 2, '.', ',') : 0}}</span>
        <p class="blue-grey-400 font-weight-100 m-0">Current total active capital</p>
        </div>
    </div>
    </div>
</div>

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
        <p class="blue-grey-400 font-weight-100 m-0">Last month commissions {{!empty(monthlyRecords('commissions', $user->id)->last->first()) ? number_format(monthlyRecords('commissions', $user->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
        </div>
    </div>
    </div>
</div>

<div class="col-md-4">
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
        <p class="blue-grey-400 font-weight-100 m-0">Last month earnings {{!empty(monthlyRecords('earnings', $user->id)->last->first()) ? number_format(monthlyRecords('earnings', $user->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
        </div>
    </div>
    </div>
</div>

<div class="col-md-4">
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
        <p class="blue-grey-400 font-weight-100 m-0">Last month cashin total {{!empty(monthlyRecords('cashin', $user->id)->last->first()) ? number_format(monthlyRecords('cashin', $user->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
        </div>
    </div>
    </div>
</div>

<div class="col-md-4">
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
        <p class="blue-grey-400 font-weight-100 m-0">Last month cashout total {{!empty(monthlyRecords('cashout', $user->id)->last->first()) ? number_format(monthlyRecords('cashout', $user->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
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
        <p class="blue-grey-400 font-weight-100 m-0">Last month diamonds {{!empty(monthlyRecords('diamonds', $user->id)->last->first()) ? number_format(monthlyRecords('diamonds', $user->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
        </div>
    </div>
    </div>
</div>
