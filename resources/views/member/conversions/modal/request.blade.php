<!-- Modal -->
<div class="modal fade" id="conversionRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{url('res/diamond/conversion')}}" id="conversionRequestForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="">
        <input type="hidden" name="item_id" value="">
        <div class="modal-body pt-0">
            <div class="row pt-0 px-20">
                <div class="col-lg-12 pt-0 pb-20 px-0">
                    <h3 class="modal-title mt-0" id="exampleModalLabel">Diamond Conversion</h3>
                </div>

                <div class="col-lg-3">
                    <img src="" width="100" height="100" class="img rounded cover item--img" alt="">
                </div>
                
                <div class="col-lg-9">
                    <h4 class="item--name">----</h4>
                </div>

                <div class="col-md-8 pr-0">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="details[receivers_name]">
                        <label class="floating-label">Receivers Name</label>
                    </div>
                </div>

                <div class="col-md-4 pr-0">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="details[contact_no]">
                        <label class="floating-label">Contact No.</label>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="shipping_details[address]" value="{{old('shipping_details.address')}}" required>
                        <label class="floating-label">Address</label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="shipping_details[apartment]" value="{{old('shipping_details.apartment')}}">
                        <label class="floating-label">Apartment, suite, etc.</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="shipping_details[city]" value="{{old('shipping_details.city')}}" required>
                        <label class="floating-label">City</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="shipping_details[region]" value="{{old('shipping_details.region')}}" required>
                        <label class="floating-label">Region</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="shipping_details[postal_code]" value="{{old('shipping_details.postal_code')}}" required>
                        <label class="floating-label">Postal Code</label>
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