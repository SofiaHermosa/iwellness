@if(Session::has('play_ads') && !Session::has('has_logged_in'))
    <!-- Modal -->
<div class="modal fade modal-full" id="playAdsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content bg-transparent">
        <div class="modal-body p-0">
            <div id="player"></div>
        </div>
      </div>
    </div>
</div>
@endif
