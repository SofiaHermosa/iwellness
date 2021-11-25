<!-- Modal -->
<div class="modal fade" id="cashinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{url('res/manage-funds')}}" id="CashInForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="1">
        <input type="hidden" class=" valid-ref_id" name="id" value="">
        <input type="hidden" name="current_attachment" value="">
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
        <div class="modal-body pt-0">
            <div class="row pt-0 px-20">
                <div class="col-lg-12 pt-0 px-0">
                    <h3 class="modal-title mt-0" id="exampleModalLabel">Cash-in Request</h3><br>
                </div>
                <div class="col-lg-12 p-0 pb-20">
                    <div class="alert dark alert-icon alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        <i class="icon wb-info" aria-hidden="true"></i>Reference numbers should be the same in the receipt.
                  </div>
                </div>
                <div class="col-lg-5 p-0 m-0">
                    <div class="col-md-12 px-0">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="form-control-label">Proof of Receipt</label>
                            <input type="file" data-plugin="dropify" class="form-control" name="attachments[]">
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-12 pr-0">
                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <input type="text" class="form-control" name="details[sender_name]">
                                <label class="floating-label">Sender Name</label>
                            </div>
                        </div>
    
                        <div class="col-md-6 pr-0">
                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <select class="form-control" name="details[mop]" required>
                                    <option value=""></option>
                                    @foreach (config('constants.mode_of_payment') as $key => $mop)
                                      <option value="{{$mop}}">{{$mop}}</option>
                                    @endforeach
                                </select>
                                <label class="floating-label">Mode of Payment</label>
                            </div>
                        </div>
        
                        <div class="col-md-6 pr-0">
                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <input type="text" class="form-control  valid-ref_no" name="details[reference_no]">
                                <label class="floating-label">Reference #</label>
                            </div>
                        </div>
        
                        <div class="col-md-12 pr-0">
                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <input type="text" class="form-control money" name="amount">
                                <label class="floating-label">Amount</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
</div>