<!-- Modal -->
<div class="modal fade" id="SurveyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-adjust_top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Survey Questions</h4>
        </div>
        <form method="POST" action="{{url('res/survey')}}" enctype='multipart/form-data' id="surveyForm">
            @csrf
            <input type="hidden" name="id" value="">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group form-material" data-plugin="formMaterial">
                            <input type="text" class="form-control" name="question">
                            <label class="floating-label">Question</label>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group form-material floating" data-plugin="formMaterial">
                            <input type="text" class="form-control" data-plugin="tokenfield" name="answer">
                            <label class="floating-label">Answer</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#surveyForm').submit()" class="btn btn-info">Update</button>
            </div>
        </form>
      </div>
    </div>
</div>