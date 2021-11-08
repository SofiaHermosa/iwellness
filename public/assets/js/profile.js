let Profile = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            form: $('#activateAccount'),
        };

        return _ui;
    }

    function bindEvents() {

    } 

    function onLoad() {
        initializeFormValidation();
    }

    function initializeFormValidation(){
        $("#activateAccount").validate({
            rules: {
                'amount' : {
                    required : true,
                    min: 700,
                    number: true
                }
            },
            messages: {
                'amount' : {
                    required : "Please enter your activation capital",
                    min: "Amount can't be less than 700",
                    number: "Please enter a valid amount"
                }
            }    
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
    Profile.init();

    console.log('asdasdasdasas');
});
