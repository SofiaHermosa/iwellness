@extends('admin.layout')

@section('page_header')
Order Invoice
@endsection

@section('page_title')

@endsection

@section('content')
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-lg-3">
                  <h3>
                    <img class="mr-10" width="200" src="{{asset('assets/images/iwellness_logo_text.png')}}"
                      alt="...">
                      {{-- IWellness --}}
                    </h3>
                  <address>
                    {{$order->full_address}}
                    <br> {{ucwords($order->details->city)}}, {{ucwords($order->details->region)}}, {{ucwords($order->details->postal_code)}}
                    <br>
                    <abbr title="Mail">E-mail:</abbr>&nbsp;&nbsp;{{$order->details->email}}
                    <br>
                    <abbr title="Phone">Phone:</abbr>&nbsp;&nbsp;{{$order->details->contact_no}}
                  </address>
                </div>
                <div class="col-lg-4 offset-lg-5 text-right">
                  <h4>Order Info</h4>
                  <p>
                    <a class="font-size-40 text-warning" href="javascript:void(0)">{{$order->order_id}}</a>
                    <br> To:
                    <br>
                    <span class="font-size-20">{{$order->details->name}}</span>
                  </p>
                  <span>Date Ordered: {{$order->created_at->format('F d, Y')}}</span>
                </div>
              </div>
  
              <div class="page-invoice-table table-responsive mt-4">
                <table class="table table-hover text-right">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Description</th>
                      <th class="text-right">Quantity</th>
                      <th class="text-right">Unit Cost</th>
                      <th class="text-right">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($order->cart as $key => $item)
                    <tr>
                        <td class="text-center">
                          {{$key + 1}}
                        </td>
                        <td class="text-left">
                          {{$item->details->name}}
                        </td>
                        <td>
                          {{$item->quantity}}
                        </td>
                        <td>
                          ₱ {{$item->price}}
                        </td>
                        <td>
                          ₱ {{$item->price * $item->quantity}}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              @php
                  $payment_charge = ($order->total + $order->shipping_fee) * 0.06;
              @endphp
              <div class="text-right clearfix mt-4">
                <div class="float-right">
                  <p class="font-size-16">Sub - Total amount:
                    <span>₱ {{number_format($order->total, 2, '.', ',')}}</span>
                  </p>
                  <p class="font-size-16">Payment Charge:
                    <span>₱ {{number_format($order->payment_charge, 2, '.', ',')}}</span>
                  </p>
                  <p class="font-size-16">Shipping Fee:
                    <span>₱ {{number_format($order->shipping_fee, 2, '.', ',')}}</span>
                  </p>
                  <p class="page-invoice-amount font-size-26">Total:
                    <span>₱ {{number_format($order->total + $order->shipping_fee + $order->payment_charge, 2, '.', ',')}}</span>
                  </p>
                </div>
              </div>
            </div>
        </div>

        @if (auth()->user()->hasanyrole('system administrator'))
          <form action="{{url('res/orders/'.$order->id)}}" method="POST" id="orderInvoiceForm">
            @csrf
            @method('PUT')

            <button type="button" class="btn btn-info float-right btn-animate btn-animate-side btn--delivered">
              <span>
                  <i class="icon ti-truck" aria-hidden="true"></i>
                  Delivered
              </span>
            </button>
          </form> 
        @endif
    </div>                  
@endsection

@push('scripts')
<script src="{{asset('assets/js/orders.js')}}"></script>
@endpush        