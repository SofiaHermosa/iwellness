@forelse (getConversionItems()->data as $item)
<div class="col-lg-3">
  <a class="btn-block" href="javascript:void(0)">
    <div class="panel">
        <div class="panel-body container-fluid p-0">
            <div class="card diamond-conversion__card" data-item="{{base64_encode(json_encode($item))}}">
                <img class="card-img-top w-full product--cover" height="200" src="{{asset('storage/'.$item->images[0])}}" alt="Card image cap">
                <div class="card-block p-4">
                  <h5 class="card-title mt-2">{{$item->name}}</h5>
                  <p class="card-text price"><i class="icon fa-diamond"></i> {{ $item->price }}</p>
                </div>
            </div>
        </div>
    </div>
  </a>  
</div>
@empty 
<div class="col-lg-12 pt-60">
    <h3 class="text-center mt-60 text-muted">No item for diamond conversion yet.</h3>
</div>
@endforelse