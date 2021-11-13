<!-- Modal -->
@php
$balance = dashboardcontent(auth()->user()->id);
@endphp

<div class="modal fade" id="cashoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{url('res/manage-funds')}}" id="CashOutForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="2">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
        <div class="modal-body pt-0">
            <div class="row pt-0 px-20">
                <div class="col-lg-12 pt-0 pb-20 px-0">
                    <h3 class="modal-title mt-0" id="exampleModalLabel">Cash-out Request</h3>
                </div>

                <div class="col-md-6">
                    <div class="card py-40">
                        <div class="card-block bg-gray p-20">
                        <button type="button" class="btn btn-floating btn-sm btn-primary">
                            <i class="icon fa-dollar"></i>
                            </button>
                            <span class="ml-15 font-weight-400">TOTAL EARNING</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon ti-triangle-up font-size-20">
                            </i>
                            <span class="font-size-40 font-weight-100">{{!empty($dashboard->commissions) ? number_format($dashboard->commissions->sum('amount'), 2, '.', ',') : 0}}</span>
                            <p class="blue-grey-400 font-weight-100 m-0">Last month commissions {{!empty(monthlyRecords('commissions', auth()->user()->id)->last->first()) ? number_format(monthlyRecords('commissions', auth()->user()->id)->last->sum('amount'), 2, '.', ',') : 0}}</p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 row p-lg-0">
                    <div class="col-md-12 pr-0">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="details[receivers_name]">
                            <label class="floating-label">Receivers Name</label>
                        </div>
                    </div>
    
                    <div class="col-md-6 pr-0">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <select class="form-control" name="details[mot]" required>
                                <option value=""></option>
                                @foreach (config('constants.mode_of_payment') as $key => $mop)
                                  <option value="{{$mop}}">{{$mop}}</option>
                                @endforeach
                            </select>
                            <label class="floating-label">Mode of Transfer</label>
                        </div>
                    </div>
    
                    <div class="col-md-6 pr-0">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="details[account_no]">
                            <label class="floating-label">Account/Phone No.</label>
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
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
</div>