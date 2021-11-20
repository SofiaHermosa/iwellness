<!-- This example requires Tailwind CSS v2.0+ -->
<div class="hidden fixed z-10 inset-0 overflow-y-auto toggle-cont" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="viewCart">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity close-modal" data-toggle="#viewCart" aria-hidden="true"></div>

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
      <form action="{{url('res/checkout/cart')}}" method="GET">
      <div class="bg-white px-2 pt-5 pb-4 sm:p-6 sm:pb-4" id="cart">
        <div class="sm:flex sm:items-start" id="cartCont">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-2xl leading-6 font-medium text-gray-900" id="modal-title">
              Cart
            </h3>
             
            <div class="w-full py-4 pr-2">
              <table class="w-full" cellpadding="1">
                    @php
                        $total = [];
                    @endphp
                    @forelse (Session::has('my-cart') ? json_decode(Session::get('my-cart')) : [] as $key => $cart)
                        <tr>
                            <td class="px-2">
                                <input type="checkbox" class="icheckbox-orange mt-4" id="checkOrders" name="checkout[]" data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue" checked value="{{base64_encode($key)}}"/>
                            </td>
                            <td>{!! $cart->details->cover !!}</td>
                            <td><p class="my-2 w-32 md:w-80" for="checkOrders">{{ $cart->details->name }}</p>
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
                            <td>
                                <div class="form-group p-4">
                                    <input class="p-2 bg-gray-100 text-center w-20 cartProdQty" data-id="{{$key}}" value="{{ $cart->quantity }}">   
                                </div>
                            </td>
                            <td clas="p-2">
                                <button type="button" class="vertical-middle m-auto py-1 px-2 text-base font-bold text-white bg-red-600 rounded cartProdDlt" data-id="{{$key}}">
                                    <i class="icon ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty    
                    <tr>
                        <td colspan="5" class="text-center">
                            <h1 class="text-lg font-extrabold text-gray-400 w-full text-center py-4">No item yet.</h1>
                        </td>
                    </tr>
                    @endforelse
                </table>
                <table class="w-full mt-2">
                    <tr>
                        <td class="text-left">
                            <h3 class="text-lg font-bold">Total:</h3>
                        </td>
                        <td class="text-right">
                            <h3 class="text-lg font-bold">{{number_format(array_sum($total), 2, '.', ',')}}</h3>
                        </td>
                    </tr>    
                </table>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-500 text-base font-medium text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
          Proceed to Checkout
        </button>
        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-modal" data-toggle="#viewCart">
          Close
        </button>
      </div>
</form>
    </div>
  </div>
</div>
