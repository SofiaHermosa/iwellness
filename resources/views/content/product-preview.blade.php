@extends('admin.layout')

@section('page_header')
Product
@endsection

@section('page_title')

@endsection

@section('content')
    @php
    $product = getProducts(request()->id)->data->first();
    @endphp

    <div class="col-lg-7">
        @if ($product->discounted_price['price'])
        <h4 class="discount--percent mr-4">
          {{$product->discounted_price['percentage']}}% OFF
        </h4>
        @endif
        <img src="{{asset('storage/'.$product->images[0])}}" class="img-fluid rounded" alt="">
    </div>
    <div class="col-lg-5">
        <div class="panel">
            <div class="panel-body container-fluid">
                <h2 class="text-center">{{ucwords($product->name)}}</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-4 product--description">
                            {!! base64_decode($product->description) !!}
                        </div>
                    </div>
    
                    <div class="col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-icon btn-dark m-0 updtQuantity" data-ops="0">
                                    <i class="icon md-minus" aria-hidden="true"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control text-center" min="1" id="prodQty" value="1">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-icon btn-dark m-0 updtQuantity" data-ops="1">
                                    <i class="icon md-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 text-right">
                        @if ($product->discounted_price['price'])
                        <h2>₱ <span class="prod--price">{{ $product->discounted_price['price'] }}</span> &nbsp;&nbsp;<span class="discount--price">{{ $product->price }}</span></h2>
                        @else
                        <h2 class="discount--price" style="text-decoration: none !important;">₱ {{ $product->price }}</h2>
                        @endif
                    </div>
                    <input type="hidden" name="prod_id" id="prodId" value="{{$product->id}}">
                    <input type="hidden" id="price" value="{{ $product->discounted_price['price'] ?? 0 }}">
                    <input type="hidden" id="discounted" value="{{ $product->price ?? 0 }}">

                    <div class="col-md-12 mt-4 pt-4">
                        <button class="btn btn-lg btn-block btn-info add--to_cart">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>  
    </div>                  
@endsection

@push('scripts')
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/products.js')}}"></script>
@endpush        