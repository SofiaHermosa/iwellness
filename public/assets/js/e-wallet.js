let EWallet = (function () {
    let ui = {};

    function bindUi() {
        this._ui = {
            btnPayWithWallet: $('.btn-pay-with-walltet'),
        };

        return _ui;
    }

    function bindEvents() {
        ui.btnPayWithWallet.on('click', payWithWallet)
        $('.tab--payment').on('click', switchPrices);
    } 

    function onLoad() {
        
    }

    function payWithWallet(){
        const balance = parseInt(atob(window.balance).replace(/[$]/g, 0));
        const price   = parseInt(atob(window.amount).replace(/[$]/g, 0));
        const type    = window.type;


        if(balance >= price){
            Swal.fire({
                iconHtml: '<i class="font-size-80 ti-lock text-primary"></i>',
                text: "To proceed enter your password",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                input: 'password',
                inputAttributes: {
                    placeholder: 'Type your password...',
                    autocapitalize: 'off',
                },
                customClass: {
                    icon: 'no-border'
                },
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Loading...',
                        html: `Please wait don't close or reload the page...`,
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                          Swal.showLoading()
                        }
                    });

                    const data = {
                        password : result.value,
                        amount   : price,
                        type     : type,
                        _token   :  $('meta[name="csrf-token"]').attr('content'),
                        complan  : window.complan ?? 1
                    };

                    $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
            
                    $.ajax({
                        url: baseURL + `pay-with-wallet`,
                        type: "POST",
                        data: data,
                        success: function (response, status) {
                            Swal.close();
                            showSuccess(response.url);
                        },
                        error: function (response) {
                            Swal.close();
                            switch (response.status) {
                                case 401:
                                    incorrectPass();
                                    break;
                            
                                default:
                                    alertify.error("Something went wrong");
                                    break;
                            }
                        },
                    });
                }
            });  
        } else {
            Swal.fire({
                icon: 'error',
                title: "Insufficient Balance",
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Close',
            })
        } 
    }

    function showSuccess(url) {
        Swal.fire({
            title: "Success!",
            text: "Payment Successfully sent!",
            icon: "success",
            showCancelButton: false,
            showConfirmButton: true,
            allowOutsideClick: false,
            confirmButtonText: 'Close',
        }).then((result) => {
            window.location.href = url;
        });
    }

    function incorrectPass() {
        Swal.fire({
            title: "Incorrect Password!",
            text: "Can't procced cause you entered invalid password",
            icon: "error",
            showCancelButton: true,
            showConfirmButton: true,
            allowOutsideClick: false,
            confirmButtonText: 'Re-try',
        }).then((result) => {
            if (result.isConfirmed) {
                payWithWallet();
            }
        });
    }

    function switchPrices(){
        var target = $(this).data('target');
        $('.pay__cont').addClass('hidden');
        $(target).removeClass('hidden');
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
    EWallet.init();
});
