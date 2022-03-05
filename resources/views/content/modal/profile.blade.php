<!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-adjust_top" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <a class="profile--avatar" href="javascript:void(0)">
                <img src="{{auth()->user()->prof_img}}" id="profImg" alt="...">
            </a>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{url('res/user/profile/'.auth()->user()->id)}}" enctype='multipart/form-data' id="editProfileForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="transaction_type" value="1">
        <div class="modal-body">
            <div class="row pt-40">
                <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="name" value="{{auth()->user()->name ?? ''}}">
                        <label class="floating-label">Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="username" value="{{auth()->user()->username ?? ''}}" readonly>
                        <label class="floating-label">Username</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="email" value="{{auth()->user()->email ?? ''}}">
                        <label class="floating-label">Email</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="contact" value="{{auth()->user()->contact ?? ''}}">
                        <label class="floating-label">Contact No.</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <select class="form-control" name="secret_question[question]" required>
                            <option value=""></option>
                            @foreach (config('constants.questions') as $key => $question)
                            <option value="{{$key}}" {{(auth()->user()->secret_question->question ?? '') == $key ? 'selected' : ''}}>{{$question}}</option>
                            @endforeach
                        </select>
                        <label class="floating-label">Secret Question</label>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="form-group form-material" data-plugin="formMaterial">
                        <input type="text" class="form-control" name="secret_question[answer]" value="{{auth()->user()->secret_question->answer ?? ''}}">
                        <label class="floating-label">Answer</label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group form-material" data-plugin="formMaterial">
                        <input type="password" class="form-control" name="password" id="password">
                        <label class="floating-label">Password</label>

                        <span class="input-group-btn input-group-append pl-1">
                            <button class="btn btn-link btn-icon py-2 showPass" type="button"><i class="pass-icon icon fa-eye"></i></button>
                        </span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="input-group form-material" data-plugin="formMaterial">
                        <input type="password" class="form-control" name="password_confirmation">
                        <label class="floating-label">Retype Password</label>

                        <span class="input-group-btn input-group-append pl-1">
                            <button class="btn btn-link btn-icon py-2 showPass" type="button"><i class="pass-icon icon fa-eye"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <input type="file" name="prof_img" style="opacity:0;" id="imgInp"  accept="image/png, image/jpeg"  onchange="previewFile(this);">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Update</button>
        </div>
        </form>
      </div>
    </div>
</div>