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

                <div class="col-md-12 pr-0">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Account/Phone No.</label>
                        <input type="text" class="form-control" name="details[account_no]" readonly>
                    </div>
                </div>

                <!-- <div class="col-md-6 pr-0">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Amount</label>
                        <input type="text" class="form-control money text-right" name="amount" readonly>
                    </div>
                </div> -->

                <div class="col-lg-12 text-right mb-4 px-0">
                    <table width="50%" class="float-right">
                        <tr>
                            <th class="font-size-16">Sub Total: </th>
                            <td class="font-size-16  cashout-sub__total">20000000000</td>
                        </tr>
                        <tr>
                            <th class="font-size-16">Maintenance Fee: </th>
                            <td class="font-size-16  cashout-maintenance__fee">2000000000</td>
                        </tr>

                        <tr>
                            <th class="font-size-16">Grand Total: </th>
                            <td class="font-size-16  cashout-grand__total">1000000000</td>
                        </tr>
                    </table>
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