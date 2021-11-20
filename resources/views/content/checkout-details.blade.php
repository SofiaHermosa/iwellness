@extends('admin.layout')

@section('page_header')
Checkout Information
@endsection

@section('page_title')

@endsection

@section('content')
    <div class="col-lg-7">
        <form action="{{url('res/checkout/payment')}}" id="shippingDetailsForm" method="POST">
        @csrf    
        <input type="hidden" name="orders" value="{{base64_encode(json_encode($toCheckedOut))}}">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <h4>Shipping Information</h4>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[name]" value="{{auth()->user()->name ?? old('shipping_details.name')}}" required>
                            <label class="floating-label">Full Name</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[contact_no]" value="{{auth()->user()->contact ?? old('shipping_details.contact_no')}}" required>
                            <label class="floating-label">Phone</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[email]" value="{{auth()->user()->email ?? old('shipping_details.email')}}" required>
                            <label class="floating-label">Email</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[company]" value="{{auth()->user()->company ?? old('shipping_details.company')}}">
                            <label class="floating-label">Company (Optional)</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[address]" value="{{old('shipping_details.address')}}" required>
                            <label class="floating-label">Address</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[apartment]" value="{{old('shipping_details.apartment')}}">
                            <label class="floating-label">Apartment, suite, etc.</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[postal_code]" value="{{old('shipping_details.postal_code')}}" required>
                            <label class="floating-label">Postal Code</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[city]" value="{{old('shipping_details.city')}}" required>
                            <label class="floating-label">City</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="shipping_details[region]" value="{{old('shipping_details.region')}}" required>
                            <label class="floating-label">Region</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <button type="button" id="proceedCheckoutPayment" class="btn btn-info float-right btn-animate btn-animate-side">
            <span>
                <i class="icon ti-credit-card" aria-hidden="true"></i>
                Proceed to payment
            </span>
        </button>
        </form>
    </div> 

    <div class="col-lg-5 p-0">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body container-fluid">
                    <table class="table table-borderless">
                        @php
                            $total = [];
                        @endphp
                        @forelse ($toCheckedOut as $key => $checkout)
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

        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body container-fluid">
                    @php
                        $shipping_fee   = array_sum($total) <= 5000 ? 120 : 200;
                        $payment_charge = (array_sum($total) + $shipping_fee) * 0.03;
                    @endphp
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

                        <tr>
                            <td colspan="2" class="text-left">
                                <h5>Payment Charge:</h5>
                            </td>
                            <td colspan="2" class="text-right">
                                <h5>₱ {{number_format($payment_charge, 2, '.', ',')}}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left">
                                <h3>Total:</h3>
                            </td>
                            <td colspan="2" class="text-right">
                                <h3>₱ {{number_format(array_sum($total) + $payment_charge + $shipping_fee, 2, '.', ',')}}</h3>
                            </td>
                        </tr>    
                    </table>
                </div>
            </div>            
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/cart.js')}}"></script>
@endpush        