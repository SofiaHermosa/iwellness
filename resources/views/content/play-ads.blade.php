@if(Session::has('play_ads'))
    <a data-fancybox data-fancybox-type="iframe"  class="hidden play--ads_link" href="{{ Session::get('play_ads') }}"></a>
@endif    
