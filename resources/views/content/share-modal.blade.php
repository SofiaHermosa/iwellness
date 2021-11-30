<!-- <div class="share--modal a2a_kit a2a_kit_size_40 a2a_vertical_style text-center a2a_floating_style " style="right:0;bottom:4rem;">
    {{-- <a class="a2a_button_copy_link"></a> --}}
    <a class="a2a_button_facebook"></a>
    <a class="a2a_button_twitter"></a>
    <a class="a2a_button_email"></a>
    <a class="a2a_button_google_gmail"></a>
    <a class="a2a_button_facebook_messenger"></a>
    <a class="a2a_button_whatsapp"></a>
    <a class="a2a_button_telegram"></a>
    <a class="a2a_button_line"></a>
    <a class="a2a_button_wechat"></a>
    <a class="a2a_button_viber"></a>
</div> -->

<!-- Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-adjust_top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

          <h3 class="modal-title">Referral Link</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg" id="referral--link" value="{{url('/register?referral='.base64_encode(auth()->user()->username))}}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-outline" id="copy-referral_link" data-placement="top" data-toggle="tooltip" data-original-title="Copy"><i class="wb-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 text-center">
                  <div class="a2a_kit a2a_kit_size_40 text-center a2a_default_style" data-a2a-url="{{ url('/register?referral='.base64_encode(auth()->user()->username)) }}">
                      <!-- <a class="a2a_button_facebook"></a> -->
                      <a class="a2a_button_twitter"></a>
                      <a class="a2a_button_email"></a>
                      <a class="a2a_button_google_gmail"></a>
                      <a class="a2a_button_facebook_messenger"></a>
                      <a class="a2a_button_whatsapp"></a>
                      <a class="a2a_button_telegram"></a>
                      <a class="a2a_button_line"></a>
                      <a class="a2a_button_wechat"></a>
                      <a class="a2a_button_viber"></a>
                  </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
