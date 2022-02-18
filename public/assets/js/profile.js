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
        $(document).on('change', 'select[name="complan"]', updateComplan);
    } 

    function onLoad() {
        initializeFormValidation();
    }

    function initializeFormValidation(){
        $("#activateAccount").validate({
            rules: {
                'amount' : {
                    required : true,
                    min: 500,
                    number: true
                },
                'complan' : {
                    required : true
                }
            },
            messages: {
                'amount' : {
                    required : "Please enter your activation capital",
                    min: "Amount can't be less than 500",
                    number: "Please enter a valid amount"
                },
                'complan' : {
                    required : "Please select subscription type",
                }
            }    
        });
    }

    function updateComplan(){
        let desc = $(this).find(':selected').attr('data-desc');
        let sub  = $(this).find(':selected').attr('data-sub');
        let min  = $(this).find(':selected').attr('data-min');

        console.log(min);

        $('#activateAccount').find('input[name="amount"]').rules('remove');
        $('#activateAccount').find('input[name="amount"]').rules('add', {
            required : true,
            min: parseInt(min),
            number: true,
            messages: {
                required : "Please enter your activation capital",
                min: "Amount can't be less than "+min,
                number: "Please enter a valid amount"
            }
        });

        $('.complan-desc_cont').find('span.complan__desc').html(desc);
        $('small.complan__sub').text(sub);
        $('.complan-desc_cont').fadeIn();
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
});
