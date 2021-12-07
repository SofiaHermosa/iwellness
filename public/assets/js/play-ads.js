let Ads = (function () {
    let ui = {};
    let link;
    let player;

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

    function checkForAds(){
       $.get(`${baseURL}res/has/ads/get`).done(function(res){
          if(res !== null){
            playAds(res);
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
