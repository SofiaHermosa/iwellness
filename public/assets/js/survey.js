let Survey = (function () {
    let ui          = {};
    let surveyForm  = '';

    function bindUi() {
        this._ui = {
           saveBtn: $('.save-template')
        };

        return _ui;
    }

    function bindEvents() {
        $(document).on('click', '.save-template', saveSurvey);
    } 

    function onLoad() {
        initializeFormBuilder();
    }


    function initializeFormBuilder(){
        surveyForm = $('#surveyBuilder').formBuilder();
    }

    function saveSurvey(){
        let questionaire = surveyForm.actions.getData('json');

        console.log(questionaire);
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
    Survey.init();
});
