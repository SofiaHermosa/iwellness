<div class="block w-full py-10 px-4 lg:mt-0 md:mt-10 sm:mt-4" id="productSection">
    <h1 data-aos="fade-down" data-aos-duration="700" class="text-lg text-gray-900 font-black text-center py-10">PRODUCTS</h1>
    <div class="grid grid-cols-4 gap-6">
        @forelse (getProducts()->data as $key => $product)
            <div class="col-span-4 md:col-span-2 lg:col-span-1">
                <a class="btn-block" href="{{url('res/product/'.$product->id.'/view')}}">
                    <div class="flex-col h-full p-6 rounded-md">
                        <div class="w-full">
                            <img class="w-full h-60 rounded object-cover object-center" src="{{asset('storage/'.$product->images[0])}}" alt="">
                        </div>
                        <div class="w-full pt-6 pb-2">
                            <p class="w-full text-md text-gray-500 font-bold">
                            {{$product->name}}
                            </p>
                        </div>
                        <div class="grid grid-cols-3 gap-0 mt-2">
                            <div class="col-span-1 text-gray-800">
                                @if ($product->discounted_price['price'])
                                <p class="card-text price text-md font-extrabold">₱ {{ $product->discounted_price['price'] }}&nbsp;&nbsp;<span class="discount--price text--medium">{{ $product->price }}</span></p>
                                @else
                                <p class="card-text price text-md font-extrabold">₱ {{ $product->price }}</p>
                                @endif

                                <input type="hidden" name="prod_id" id="prodId" value="{{$product->id}}">
                                <input type="hidden" id="price" value="{{ $product->discounted_price['price'] ?? 0 }}">
                                <input type="hidden" id="discounted" value="{{ $product->price ?? 0 }}">
                                <input type="hidden" class="form-control text-center" min="1" id="prodQty" value="1">
                            </div>

                            <div class=" col-span-2 text-right">
                                <a href="javascript:void(0)" class="rounded-md py-2 px-4 bg-yellow-300 text-white text-xs font-extrabold add--to_cart" data-qty="1" data-id="{{$product->id}}">ADD TO CART</a>
                            </div>
                        </div>
                    </div>
                </a>  
            </div>
        @empty 
        <div class="col-lg-12 pt-60">
            <h3 class="text-center mt-60 text-muted">No available products yet.</h3>
        </div>
        @endforelse 
    </div>
</div>