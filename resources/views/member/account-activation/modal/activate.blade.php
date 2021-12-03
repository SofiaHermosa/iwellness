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
                        <label>Amount</label>
                        <small>(Minimum of 700 pesos)</small>
                        <input type="number" class="form-control" name="amount">
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