@extends('admin.layout')

@section('page_title')
<div class="page-header">
    <h1 class="page-title">{{ucwords(config('constants.payment_transaction_type.'.request()->transaction_type))}}</h1>
</div>
@endsection

@section('content')
@include('payment.modal.auth-modal')
@php
   $bat = 0.03 * request()->amount;
@endphp
{{-- <div class="col-lg-8">
    <div class="panel">
        <div class="panel-body container-fluid">
                
        </div>
    </div>
</div> --}}
<div class="col-lg-8">
    <div class="panel nav-tabs-horizontal" data-plugin="tabs">
        <ul class="nav nav-tabs nav-tabs-line" role="tablist">
            <li class="nav-item tab--payment" data-target=".paymongo--cont"><a class="nav-link" data-toggle="tab" href="#exampleTopHome" aria-controls="exampleTopHome" role="tab" aria-expanded="true" aria-selected="true"><i class="icon fa-credit-card" aria-hidden="true"></i>Online Payment</a></li>
            <li class="nav-item tab--payment" data-target=".wallet--cont"><a class="nav-link active show" data-toggle="tab" href="#exampleTopComponents" aria-controls="exampleTopComponents" role="tab" aria-selected="false"><i class="icon md-balance-wallet" aria-hidden="true"></i>Wallet</a></li>
            <li class="dropdown nav-item" style="display: none;">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">Dropdown </a>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item tab--payment" data-target=".paymongo--cont" data-toggle="tab" href="#exampleTopHome" aria-controls="exampleTopHome" role="tab"><i class="icon wb-plugin" aria-hidden="true"></i>Home</a>
                <a class="dropdown-item tab--payment" data-target=".wallet--cont" data-toggle="tab" href="#exampleTopComponents" aria-controls="exampleTopComponents" role="tab"><i class="icon wb-user" aria-hidden="true"></i>Components</a>
            </div>
            </li>
        </ul>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane" id="exampleTopHome" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container text-center py-60">
                                <h1 class="font-weight-400 text-muted">Coming Soon</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active show" id="exampleTopComponents" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-12 px-4 text-center">
                            <div class="card">
                                <div class="card-block bg-white p-20">
                                    <button type="button" class="btn btn-floating btn-sm btn-primary">
                                        <i class="icon md-balance-wallet"></i>
                                    </button>
                                    <span class="ml-15 font-weight-400">Current Balance</span>
                                    <div class="content-text">
                                        <span class="font-size-40 font-weight-100">{{number_format(auth()->user()->wallet_balance, 2, '.', ',')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-4 text-right">
                            <a href="javascript:void(0)" class="btn btn-primary m-0 btn-pay-with-walltet" data-text="Processing..."s>
                                Proceed Payment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="panel">
        <div class="panel-body container-fluid">
            <h3 class="mb-4 text-center">Details</h3>
            <div class="row mt-4">
                @php 
                    $payment_charge = request()->amount * 0.03;
                @endphp
                <table class="mt-4" width="100%">
                    <tr>
                        <td colspan="2" class="text-left">
                            <h5>Amount:</h5>
                        </td>
                        <td colspan="2" class="text-right">
                            <h5>₱ {{number_format(request()->amount)}}</h5>
                        </td>
                    </tr>  
                    <tr class="wallet--cont">
                        <td colspan="2" class="text-left">
                            <h3>Total:</h3>
                        </td>
                        <td colspan="2" class="text-right">
                            <h3>₱ {{number_format(request()->amount, 2, '.', ',')}}</h3>
                        </td>
                    </tr>
                </table>    
            </div>
        </div>
    </div>
</div>            

@endsection

@push('scripts')
<script>
    window.balance = '{!! base64_encode(str_replace('0','$',auth()->user()->wallet_balance)) !!}';
    window.amount  = '{!! base64_encode(str_replace('0','$',request()->amount)) !!}';
    window.type    = 1;
</script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/payment.js')}}"></script>
<script src="{{asset('assets/js/e-wallet.js')}}"></script>
@endpush        