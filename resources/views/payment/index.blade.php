@extends('admin.layout')

@section('page_title')
<div class="page-header">
    <h1 class="page-title">{{ucwords(config('constants.payment_transaction_type.'.request()->transaction_type))}}</h1>
</div>
@endsection

@section('content')
@php
   $bat = 0.06 * request()->amount;
@endphp
<div class="col-lg-8">
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="payment-error-message col-lg-12"></div>
            </div>

            <div class="row">
                <div class="error-message col-lg-12"></div>
            </div>
            <form action="" class="checkout-payment-form row" method="POST">
                @csrf
                
                <div class="col-lg-12">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control pay__with__card card_number_reqs empty" name="details[card_number]" data-mask="0000-0000-0000-0000" required autocomplete="current-password" id="inputCardNo">
                        <label class="floating-label" for="inputCardNo">Credit / Debit Number</label>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control pay__with__card month_reqs empty" name="details[exp_month]" data-mask="00" required autocomplete="current-password" id="inputMM">
                        <label class="floating-label" for="inputMM">MM</label>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control pay__with__card year_reqs empty" name="details[exp_year]" data-mask="00" required autocomplete="current-password" id="inputYY">
                        <label class="floating-label" for="inputYY">YY</label>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control pay__with__card cvc_reqs empty" name="details[cvc]" data-mask="000" required autocomplete="current-password" id="inputCVC">
                        <label class="floating-label" for="inputCVC">CVC</label>
                    </div>
                </div>
                <input type="hidden" id="paymongo_method" name="paymongo_method" value="card">
                <input type="hidden" name="amount" value="{{request()->amount}}">
                <input type="hidden" name="service_charge" value="{{$bat}}">
                <input type="hidden" name="transaction_type" value="{{request()->transaction_type}}">

                <div class="col-lg-12 mt-4 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary m-0 btn-place-order wt__disable_on_submit_no_form_change" data-text="Processing..."s>
                        Proceed Payment
                    </a>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="panel">
        <div class="panel-body container-fluid">
            <h3 class="mb-4 text-center">Details</h3>
            <div class="row mt-4">
                <div class="col-lg-4">
                    Amount:
                </div>

                <div class="col-lg-8 text-right">
                    {{number_format(request()->amount)}}
                </div>

                <div class="col-lg-6">
                   <small>Payment Charge:</small>
                </div>

                <div class="col-lg-6 text-right">
                    <small>{{number_format($bat)}}</small>
                </div>

                <hr class="mb-4"/>

                <div class="col-lg-6">
                    <h4>Total:</h4>
                 </div>
 
                 <div class="col-lg-6 text-right">
                     <h4>{{number_format(request()->amount + $bat)}}</h4>
                 </div>

            </div>
        </div>
    </div>
</div>            

@endsection

@push('scripts')
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/payment.js')}}"></script>
@endpush        