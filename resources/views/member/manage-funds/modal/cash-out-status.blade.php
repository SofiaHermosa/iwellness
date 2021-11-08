<!-- Modal -->
<div class="modal fade" id="cashoutStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
            <div class="row pt-0 px-20">
                <div class="col-md-12 px-4 pt-0 pb-30 row">
                    <div class="col-lg-8">
                        <h3 class="modal-title mt-0" id="exampleModalLabel">Cash-out Request</h3>
                    </div>
                    <div class="col-lg-4 text-right status--badge pt-2 px-0">

                    </div>
                </div>
               
                <div class="col-md-6 pr-0">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Receiver Name</label>
                        <input type="text" class="form-control" name="details[receivers_name]" readonly>
                    </div>
                </div>
                
                <div class="col-md-6 pr-0">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Mode of Transfer</label>
                        <select class="form-control" name="details[mot]" readonly>
                            <option value="" disabled></option>
                            @foreach (config('constants.mode_of_payment') as $key => $mop)
                                <option value="{{$mop}}" disabled>{{$mop}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 pr-0">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Account/Phone No.</label>
                        <input type="text" class="form-control" name="details[account_no]" readonly>
                    </div>
                </div>

                <div class="col-md-6 pr-0">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Amount</label>
                        <input type="text" class="form-control money" name="amount" readonly>
                    </div>
                </div>
             
                <div class="col-lg-12 reason--cont">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Reason</label>
                        <textarea class="form-control" name="reason" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info edit--cashout">Edit</button>
          <button type="button" class="btn btn-danger cashout--delete">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>