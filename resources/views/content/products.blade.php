@forelse (getProducts()->data as $product)
<div class="col-lg-3">
  <a class="btn-block" href="{{url('res/product/'.$product->id.'/view')}}">
    <div class="panel">
        <div class="panel-body container-fluid p-0">
            <div class="card">
                @if ($product->discounted_price['price'])
                <span class="discount--percent">
                  {{$product->discounted_price['percentage']}}% OFF
                </span>
                @endif
                <img class="card-img-top w-full product--cover" height="200" src="{{asset('storage/'.$product->images[0])}}" alt="Card image cap">
                <div class="card-block p-4">
                  <h5 class="card-title mt-2">{{$product->name}}</h5>
                  @if ($product->discounted_price['price'])
                  <p class="card-text price text--lg">₱ {{ $product->discounted_price['price'] }}&nbsp;&nbsp;<span class="discount--price text--medium">{{ $product->price }}</span></p>
                  @else
                  <p class="card-text price">₱ {{ $product->price }}</p>
                  @endif
                </div>
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