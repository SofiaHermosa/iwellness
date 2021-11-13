<!-- Modal -->
<div class="modal fade" id="conversionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
            <div class="row">
                <div class="col-lg-12 pb-30 row">
                    <div class="col-md-10">
                        <h3 class="modal-title mt-0" id="exampleModalLabel">Diamond Conversion <i class="icon md-caret-right ml-4" aria-hidden="true"></i> <span class="item--details"></span></h3>
                    </div>

                    <div class="col-lg-2 text-right status--badge pt-2 px-0">

                    </div>
                </div>
            
                
                <div class="col-lg-4">
                    <a class="conversion--preview_prop pt-60" data-fancybox="image" href="">
                        <img src="" width="150" height="150" class="img rounded cover" alt="">
                    </a>
                </div>

                <div class="col-lg-8 row p-0">
                    <div class="col-md-6">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="form-control-label">User</label>
                            <input type="text" class="form-control" name="user" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="form-control-label">Receivers Name</label>
                            <input type="text" class="form-control" name="receivers_name" readonly>
                        </div>
                    </div>
    
                    <div class="col-md-12">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="form-control-label">Address</label>
                            <textarea class="form-control" name="address" readonly>
                            </textarea>    
                        </div>
                    </div>
    
                    <div class="col-md-6">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <label class="form-control-label">Phone</label>
                            <input type="text" class="form-control money" name="phone" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info conversion__approve">Approve</button>
          <button type="button" class="btn btn-danger conversion__decline">Decline</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>