<!-- Modal -->
<div class="modal fade" id="activateAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Activate Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{url('payment')}}" id="activateAccount">
        @csrf
        <input type="hidden" name="transaction_type" value="1">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Subscription Type</label>
                        <select name="complan" class="form-control">
                            <option value="" selected disabled>Select Subscription</option>

                            @foreach(config('constants.complans') as $key => $complan)
                                @if(isset($complan["soon"]) && $complan["soon"])
                                <option disabled readonly value="">{{ucwords($complan['name'])}} (Soon)</option>
                                @else
                                <option value="{{$key}}" data-desc="{{$complan['desc']}}" data-sub="{{$complan['sub']}}" data-min="{{$complan['min']}}">{{ucwords($complan['name'])}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Amount</label>
                        <small class="complan__sub"></small>
                        <input type="number" class="form-control" name="amount">
                    </div>
                </div>

                <div class="col-md-12 complan-desc_cont hidden">
                  <div class="alert dark alert-icon alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        <span class="complan__desc">Reference numbers should be the same in the receipt.</span>
                  </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Activate Account</button>
        </div>
        </form>
      </div>
    </div>
</div>