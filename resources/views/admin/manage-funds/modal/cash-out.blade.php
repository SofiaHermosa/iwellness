<!-- Modal -->
<div class="modal fade" id="cashoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
            <div class="row px-20">
                <div class="col-lg-12 pb-30 row">
                    <div class="col-md-10">
                        <h3 class="modal-title mt-0" id="exampleModalLabel">Cash-out Request <i class="icon md-caret-right ml-4" aria-hidden="true"></i> <span class="mot--details"></span></h3>
                    </div>

                    <div class="col-lg-2 text-right status--badge pt-2 px-0">

                    </div>
                </div>
            
                <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">User</label>
                        <input type="text" class="form-control" name="user" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Sender Name</label>
                        <input type="text" class="form-control" name="details[receivers_name]" readonly>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Reference/Tracking #</label>
                        <input type="text" class="form-control" name="details[account_no]" readonly>
                    </div>
                </div>

                <!-- <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <label class="form-control-label">Amount</label>
                        <input type="text" class="form-control money" name="amount" readonly>
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
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info cash-out__approve">Approve</button>
          <button type="button" class="btn btn-danger cash-out__decline">Decline</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>