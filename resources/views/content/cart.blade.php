<div class="col-md-8 offset-2">
    <h1 class="page-title my-4">Cart</h1>
</div>
<div class="col-lg-8 offset-2" id="cart">
    @if(Session::has('error'))
    <div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="icon fa-warning" aria-hidden="true"></i> {{ Session::get('error') }}
    </div>
    @endif

    <div id="cartCont">
        <form action="{{url('res/checkout/cart')}}" method="GET"> 
        <div class="panel">
            <div class="panel-body container-fluid">
                <table class="table table-borderless">
                    @php
                        $total = [];
                    @endphp
                    @forelse (auth()->user()->cart as $key => $cart)
                        <tr>
                            <td width="5%">
                                <input type="checkbox" class="icheckbox-orange mt-4" id="checkOrders" name="checkout[]" data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue" checked value="{{base64_encode($key)}}"/>
                            </td>
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
                                <small>₱ {{ number_format($cart->price * $cart->quantity, 2, '.', ',') }}</small>
                                @endif
                            </td>
                            <td width="15%">
                                <div class="form-group">
                                    <input class="form-control mt-3 text-center cartProdQty" data-id="{{$key}}" value="{{ $cart->quantity }}">   
                                </div>
                            </td>
                            <td width="10%">
                                <button type="button" class="btn btn-danger btn-sm btn-icon mt-1 cartProdDlt" data-id="{{$key}}">
                                    <i class="icon ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty    
                    @endforelse
                </table>
                <table class="table">
                    <tr>
                        <td class="text-left">
                            <h3>Total:</h3>
                        </td>
                        <td class="text-right">
                            <h3>{{number_format(array_sum($total), 2, '.', ',')}}</h3>
                        </td>
                    </tr>    
                </table>
            </div>
        </div> 
        <button class="btn btn-info float-right btn-animate btn-animate-side">
            <span>
                <i class="icon ti-shopping-cart" aria-hidden="true"></i>
                Proceed to checkout
            </span>
        </button>
        </form>
    </div>       
</div>
