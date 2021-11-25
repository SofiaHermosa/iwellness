@extends('admin.layout')

@section('page_title')
<div class="page-header">
    <h1 class="page-title">{{ucwords(config('constants.payment_transaction_type.'.request()->transaction_type))}}</h1>
</div>
@endsection

@section('content')
@include('payment.modal.auth-modal')
@php
   $details = json_decode(base64_decode($checkout_details));
@endphp
@php
$total_amount = [];
@endphp
@forelse ($details->orders as $key => $checkout)
@php
    $id   = base64_decode($checkout);
    $cart = auth()->check() ? auth()->user()->cart->$id : json_decode(Session::get('my-cart'))->$id;
@endphp

@if ($cart->details->discounted_price->price)
@php
    $total_amount[] = $cart->price * $cart->quantity;
@endphp
@else
@php
    $total_amount[] = $cart->price * $cart->quantity;
@endphp
@endif

@empty    
@endforelse
<div class="col-lg-8">
    <div class="panel nav-tabs-horizontal" data-plugin="tabs">
        @if(auth()->check())
        <ul class="nav nav-tabs nav-tabs-line" role="tablist">
            <li class="nav-item tab--payment" data-target=".paymongo--cont"><a class="nav-link active show" data-toggle="tab" href="#exampleTopHome" aria-controls="exampleTopHome" role="tab" aria-expanded="true" aria-selected="true"><i class="icon fa-credit-card" aria-hidden="true"></i>Online Payment</a></li>
            <li class="nav-item tab--payment" data-target=".wallet--cont"><a class="nav-link" data-toggle="tab" href="#exampleTopComponents" aria-controls="exampleTopComponents" role="tab" aria-selected="false"><i class="icon md-balance-wallet" aria-hidden="true"></i>Wallet</a></li>
            <li class="dropdown nav-item" style="display: none;">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">Dropdown </a>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item tab--payment" data-target=".paymongo--cont" data-toggle="tab" href="#exampleTopHome" aria-controls="exampleTopHome" role="tab"><i class="icon wb-plugin" aria-hidden="true"></i>Home</a>
                <a class="dropdown-item tab--payment" data-target=".wallet--cont" data-toggle="tab" href="#exampleTopComponents" aria-controls="exampleTopComponents" role="tab"><i class="icon wb-user" aria-hidden="true"></i>Components</a>
            </div>
            </li>
        </ul>
        @endif
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="exampleTopHome" role="tabpanel">
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
                       
                        @php
                            $shipping_fee   = array_sum($total_amount) <= 5000 ? 120 : 200;
                            $payment_charge = (array_sum($total_amount) + $shipping_fee) * 0.03;
                        @endphp
                        <input type="hidden" id="paymongo_method" name="paymongo_method" value="card">
                        <input type="hidden" name="amount" value="{{array_sum($total_amount)}}">
                        <input type="hidden" name="service_charge" value="{{$payment_charge}}">
                        <input type="hidden" name="shipping_fee" value="{{$shipping_fee}}">
                        <input type="hidden" name="transaction_type" value="2">
        
                        <div class="col-lg-12 mt-4 text-right">
                            <a href="javascript:void(0)" class="btn btn-primary m-0 btn-place-order wt__disable_on_submit_no_form_change" data-text="Processing..."s>
                                Proceed Payment
                            </a>
                        </div>
                    </form>
                </div>
                @if(auth()->check())
                <div class="tab-pane" id="exampleTopComponents" role="tabpanel">
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
                @endif
            </div>
        </div>
    </div>    
</div>
<div class="col-lg-4 p-0">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body container-fluid">
                <table class="table table-borderless">
                    @php
                        $total = [];
                    @endphp
                    @forelse ($details->orders as $key => $checkout)
                        @php
                            $id   = base64_decode($checkout);
                            $cart = auth()->check() ? auth()->user()->cart->$id : json_decode(Session::get('my-cart'))->$id;
                        @endphp
                        <tr>
                            <td width="15%">{!! $cart->details->cover !!}</td>
                            <td width="65%"><p class="my-2" for="checkOrders">{{ $cart->details->name }}</p>
                                @if ($cart->details->discounted_price->price)
                                @php
                                    $total[] = $cart->price * $cart->quantity;
                                @endphp
                                <small>₱ {{ $cart->price * $cart->quantity }}&nbsp;&nbsp;<span class="discount--price">{{$cart->details->price * $cart->quantity}}</span></small>
                                @else
                                @php
                                    $total[] = $cart->price * $cart->quantity;
                                @endphp
                                <small>₱ {{ $cart->price * $cart->quantity }}</small>
                                @endif
                            </td>
                            <td width="5% pt-4">
                                <small class="checkout_details-qty">{{$cart->quantity}}x</small>
                            </td>
                        </tr>
                    @empty    
                    @endforelse
                </table>
            </div>
        </div>     
    </div> 
    <div class="col-lg"></div>
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body container-fluid">
                <table class="mt-4" width="100%">
                    <tr>
                        <td colspan="2" class="text-left">
                            <h5>Sub Total:</h5>
                        </td>
                        <td colspan="2" class="text-right">
                            <h5>₱ {{number_format(array_sum($total), 2, '.', ',')}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-left">
                            <h5>Shipping Fee:</h5>
                        </td>
                        <td colspan="2" class="text-right">
                            <h5>₱ {{number_format($shipping_fee, 2, '.', ',')}}</h5>
                        </td>
                    </tr>

                    <tr class="paymongo--cont pay__cont">
                        <td colspan="2" class="text-left">
                            <h5>Payment Charge:</h5>
                        </td>
                        <td colspan="2" class="text-right">
                            <h5>₱ {{number_format($payment_charge, 2, '.', ',')}}</h5>
                        </td>
                    </tr>
                    <tr class="paymongo--cont pay__cont">
                        <td colspan="2" class="text-left">
                            <h3>Total:</h3>
                        </td>
                        <td colspan="2" class="text-right">
                            <h3>₱ {{number_format(array_sum($total) + $payment_charge + $shipping_fee, 2, '.', ',')}}</h3>
                        </td>
                    </tr>    
                    <tr class="wallet--cont hidden pay__cont">
                        <td colspan="2" class="text-left">
                            <h3>Total:</h3>
                        </td>
                        <td colspan="2" class="text-right">
                            <h3>₱ {{number_format(array_sum($total) + $shipping_fee, 2, '.', ',')}}</h3>
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
    window.balance = '{!! base64_encode(str_replace('0','$',auth()->check() ? auth()->user()->wallet_balance : 0)) !!}';
    window.amount  = '{!! base64_encode(str_replace('0','$',array_sum($total_amount) + $payment_charge + $shipping_fee)) !!}';
    window.type    = 2;
</script>

<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/payment.js')}}"></script>
<script src="{{asset('assets/js/e-wallet.js')}}"></script>
@endpush        