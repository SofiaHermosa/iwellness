let Payment = (function () {
    let ui = {};
    let urlOrigin = baseURL;
    let paymentId;
    let transactionId;
    let paymentMethodId;
    let moduleId = $('input[name="module_id"]').val();
    let paymongo_method = "card";
    let sourceId;

    function bindUi() {
        this._ui = {
            payMongoMethod: $("#paymongo_method"),
            cardDetails: $(".card-details"),
            sourceId: $(".source-id"),
            checkoutForm: $(".checkout-payment-form"),
            placeOrderButton: $(".btn-place-order"),
            authModal: $("#authenticationModal"),
            confirmModal: $("#confirmModal"),
            processingNotif: $(".alert-popup-processing"),
            checkmark: $(".paymongo-checkmark"),
            okButton: $("#confirmModal .btn-ok"),
            gcash_method: $('.gcash-method'),
            card_method : $('.card-method'),
            pay_card    : $('.pay__with__card'),
            pay_gcash   : $('.pay__with__gcash')
        };

        return _ui;
    }

    function bindEvents() {
        $(document).on(
            "click",
            ".paymongo_pay_methods",
            onClickPaymongoPaymentMethods
        );
        $(document).on("click", ".btn-place-order", placeOrder);
        // $(document).on("click", "#confirmModal .btn-ok", placeOrder);
        $(document).on("click", "#confirmModal .btn-cancel", function () {
            enableButton(ui.placeOrderButton, "Submit Payment");
        });
        $(document).on("click", "#confirmModal .close", function () {
            enableButton(ui.placeOrderButton, "Submit Payment");
        });
        $(document)
            .off("hidden.bs.modal")
            .on("hidden.bs.modal", "#confirmModal", function () {
                enableButton(ui.placeOrderButton, "Submit Payment");
            }); 
    }

    function disableButton(button) {
        var text = "Processing...";
        button.text(text);
        button.val(text);
        button.prop("disabled", true);
    }

    function tagAsActive(){
        ui.pay_card.focusin(function(){
            ui.card_method.addClass('active');
            ui.gcash_method.removeClass('active');
            ui.payMongoMethod.val('card');
            $(
                "input[name='details[card_number]'], input[name='details[exp_year]'], input[name='details[exp_month]'], input[name='details[cvc]']"
            ).attr("required", true);
        });

        ui.pay_gcash.focusin(function(){
            ui.card_method.removeClass('active');
            ui.gcash_method.addClass('active');
            ui.payMongoMethod.val('gcash');
            $(
                "input[name='details[card_number]'], input[name='details[exp_year]'], input[name='details[exp_month]'], input[name='details[cvc]']"
            ).attr("required", false);

        });

        ui.gcash_method.click(function(){
            ui.card_method.removeClass('active');
            ui.gcash_method.addClass('active');
            ui.payMongoMethod.val('gcash');
            $(
                "input[name='details[card_number]'], input[name='details[exp_year]'], input[name='details[exp_month]'], input[name='details[cvc]']"
            ).attr("required", false);

        });

        ui.card_method.click(function(){
            $(
                "input[name='details[card_number]'], input[name='details[exp_year]'], input[name='details[exp_month]'], input[name='details[cvc]']"
            ).attr("required", true);
            ui.card_method.addClass('active');
            ui.gcash_method.removeClass('active');
            ui.payMongoMethod.val('card');
        });
    }


    function enableButton(button, text) {
        button.text(text);
        button.val(text);
        button.prop("disabled", false);
    }

    function displayCardErrorMessage(message) {
        $(".alert-danger").remove();
        var mess = `<div class="card-error alert alert-danger" role="alert" style="min-width:235px !important;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                        <p class="error-messages"> ${message}</p>
                    </div>`;
        $(".error-message").append(mess);
    }

    function displayPaymentErrorMessage(message) {
        $(".alert-danger").remove();
        var mess = `<div class="card-error alert alert-danger" role="alert" style="min-width:235px !important;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                        <p class="error-messages"> ${message}</p>
                    </div>`;
        $(".payment-error-message").append(mess);
    }

    function showConfirmModal(e) {
        e.preventDefault();
        disableButton($(this));
        $(".alert-danger").remove();
        ui.confirmModal.modal("show");
    }

    function openAuthenticationModal(url) {
        ui.authModal.find("#authIframe").attr("src", url);
        ui.authModal.modal("show");
    }

    function showProcessing() {
        swal({
            title: "Loading...",
            text:
                "Please do not refresh or close the page while we are processing your request.",
            icon: "info",
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    }

    function showSuccess() {
        swal({
            title: "Success!",
            text: "Payment Successfully sent!",
            icon: "success",
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    }

    function onClickPaymongoPaymentMethods() {
        // $(this).addClass("active").siblings().removeClass("active");

        var method = $('.paymongo_pay_methods.active').data("method");
        ui.payMongoMethod.val(method);

        $(".paymongo-checkmark").addClass("hidden");
        $(this).find(".paymongo-checkmark").removeClass("hidden");

        if (method == "card") {
            ui.cardDetails.removeClass("hidden");
            $(
                "input[name='details[card_number]'], input[name='details[exp_year]'], input[name='details[exp_month]'], input[name='details[cvc]']"
            ).attr("required", true);
        } else {
            ui.cardDetails.addClass("hidden");
            $(
                "input[name='details[card_number]'], input[name='details[exp_year]'], input[name='details[exp_month]'], input[name='details[cvc]']"
            ).removeAttr("required");
        }
    }

    function placeOrder(e) {
        e.preventDefault();
        ui.confirmModal.modal("hide");
        var formData = ui.checkoutForm.serialize();
        paymongo_method = ui.payMongoMethod.val();

        if (paymongo_method == "card") {
            if ($('.card_number_reqs').val() == "") {
                displayPaymentErrorMessage("Card number is required");
            }else if($('.cvc_reqs').val() == ""){
                displayPaymentErrorMessage("CVC is required");   
            }else if($('.month_reqs').val() == ""){
                displayPaymentErrorMessage("Month is required");   
            }else if($('.year_reqs').val() == ""){
                displayPaymentErrorMessage("Year is required");   
            }else{
                showProcessing();

                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

                $.ajax({
                    url: urlOrigin + "pay-with-card",
                    type: "post",
                    data: {
                        data: btoa(formData),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response, status) {
                        showProcessing();
                        paymentId = response.paymentIntendId;
                        transactionId = response.transactionId;
                        paymentMethodId = response.paymentMethodId;

                        if (response.requiresAuth == true) {
                            swal.close();
                            openAuthenticationModal(response.url);
                            window.location.href = `${document.referrer}`;
                        } else {
                            showProcessing();
                            swal.close();
                            showSuccess();
                            window.location.href = `${response.url}`;
                            // ui.checkoutForm.submit();
                        }
                    },
                    error: function (response) {
                        swal.close();
                        e.preventDefault();
                        displayCardErrorMessage(response.responseJSON[1]);

                        enableButton(ui.placeOrderButton, "Submit Payment");
                    },
                });
          

            ui.authModal
                .off("hidden.bs.modal")
                .on("hidden.bs.modal", function () {
                    showProcessing();
                    $.post(
                        urlOrigin +
                            "cancel-payment-intent?PaymentIntentId=" +
                            paymentId,
                        function (response, status) {
                            swal.close();
                            enableButton(ui.placeOrderButton, "Submit Payment");
                            displayPaymentErrorMessage(
                                "Authentication failed or cancelled."
                            );
                        }
                    );
                });
            }    
        } else if (
            paymongo_method == "gcash" ||
            paymongo_method == "grab_pay"
        ) {
            sourceId = null;
            showProcessing();
            $.ajax({
                url:
                    urlOrigin +
                    "gcash-or-grabpay?method=" +
                    paymongo_method +
                    "&moduleId=" +
                    moduleId,
                type: "post",
                success: function (response, status) {
                    swal.close();
                    openAuthenticationModal(response.url);
                    ui.sourceId.val(response.sourceId);
                    sourceId = response.sourceId;
                },
                error: function (response) {
                    e.preventDefault();
                    enableButton(ui.placeOrderButton, "Submit Payment");
                    displayPaymentErrorMessage(response.responseJSON[1]);
                },
            });

            ui.authModal
                .off("hidden.bs.modal")
                .on("hidden.bs.modal", function () {
                    showProcessing();
                    $.ajax({
                        url:
                            urlOrigin +
                            "check-wallet-status?source-id=" +
                            sourceId,
                        type: "post",
                        success: function (response, status) {
                            console.log(response);
                            if (response.chargeable == true) {
                                $.ajax({
                                    url:
                                        urlOrigin +
                                        "send-gcash-grabpay-payment?source-id=" +
                                        sourceId +
                                        "&moduleId=" +
                                        moduleId,
                                    type: "post",
                                    success: function (response) {
                                        swal.close();
                                        ui.checkoutForm.submit();
                                    },
                                    error: function (response) {
                                        swal.close();

                                        e.preventDefault();
                                        enableButton(
                                            ui.placeOrderButton,
                                            "Submit Payment"
                                        );
                                        displayPaymentErrorMessage(
                                            response.responseJSON[1]
                                        );
                                    },
                                });
                            } else {
                                swal.close();
                                e.preventDefault();
                                enableButton(
                                    ui.placeOrderButton,
                                    "Submit Payment"
                                );
                                displayPaymentErrorMessage(
                                    "Authentication failed or cancelled."
                                );
                            }
                        },
                    });
                });
        }
    }

    function onLoad() {
        // set selected paymongo method to card
        ui.payMongoMethod.val("card");
        paymongo_method = "card";

        window.addEventListener(
            "message",
            (ev) => {
                if (ev.data === "3DS-authentication-complete") {
                    _ui.authModal.modal("hide");
                    $.ajax({
                        url: urlOrigin + "get-payment-status",
                        type: "get",
                        data: {
                            paymentId: btoa(paymentId),
                            transactionId: btoa(transactionId),
                            paymentMethodId: btoa(paymentMethodId),
                            moduleId: btoa(moduleId),
                        },
                        success: function (response) {
                            if (response.status === "succeeded") {
                                swal.close();
                                showSuccess();
                                ui.checkoutForm.submit();
                            } else if (
                                response.status == "awaiting_payment_method"
                            ) {
                                swal.close();
                                ev.preventDefault();
                                displayPaymentErrorMessage(
                                    "Authentication failed or cancelled."
                                );
                                enableButton(
                                    ui.placeOrderButton,
                                    "Submit Payment"
                                );
                            }
                        },
                    });
                }
            },
            false
        );
    }

    function init() {
        ui = bindUi();
        bindEvents();
        onLoad();
        tagAsActive();   
    }

    return {
        init: init,
        _ui: ui,
    };
})();

$(document).ready(function () {
    Payment.init();
});
