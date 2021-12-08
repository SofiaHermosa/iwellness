let Ads = (function () {
    let ui = {};
    let link;
    let player;
    let done = false;

    function bindUi() {
        this._ui = {
            form: $('#activateAccount'),
        };

        return _ui;
    }

    function bindEvents() {

    } 

    function onLoad() {
        checkForAds();
    }

    function onYouTubeIframeAPIReady(id) {
        player = new YT.Player('player', {
            height: '100%',
            width: '100%',
            videoId: id,
            playerVars: { autoplay: 1, rel: 0, controls: 0, showinfo: 0, ecver: 2},
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerStateChange(event) {
        if (player.getPlayerState() == 0) {
            deleteSessionAds();
            $('#playAdsModal').modal('hide');
        }
    }
    
    function stopVideo() {
        player.stopVideo();
    }

    function onPlayerReady(event) {
        event.target.playVideo();
        player.playVideo();
    }

    function checkForAds(){
       $.get(`${baseURL}res/has/ads/get`).done(function(res){
          if(res !== null){
            let videoID = res.split('/');
            $('#playAdsModal').modal({
                show:true,
                backdrop: 'static',
                keyboard: false
            });
            onYouTubeIframeAPIReady(videoID[4]);
          }
       });
    }

    function playAds(link){
        $('.play--ads_link').fancybox({
            clickSlide: false,
            clickOutside: false,
            helpers : {
                media: true,
                closeBtn:false
            }
        }).trigger('click');

        deleteSessionAds();
    }
    

    function deleteSessionAds(){
        $.get(`${baseURL}res/has/ads/remove`).done(function(res){
    
        });
    }

    function init() {
        ui = bindUi();
        bindEvents();
        onLoad();  
    }

    return {
        init: init,
        _ui: ui,
    };
})();

$(document).ready(function () {
    Ads.init();
});
