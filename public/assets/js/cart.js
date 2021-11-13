let Cart = (function () {
    let ui = {};

    function bindUi() {
        this._ui = {
            cartProdQty: $('.cartProdQty'),
        };

        return _ui;
    }

    function bindEvents() {
        $(document).on('change', '.cartProdQty', updateCartQty);
        $(document).on('click', '.cartProdDlt', deleteProdCart);
        $(document).on('click', '#proceedCheckoutPayment', proceedCheckoutPayment);
    } 

    function onLoad() {
        validateForm();
    }

    function validateForm(){
        $("#shippingDetailsForm").validate({
            rules: {
                "shipping_details[name]": "required",
                "shipping_details[contact_no]": {
                    required: true,
                    maxlength: 12,
                    minlength: 11,
                },
                "shipping_details[email]": {
                    required: true,
                    email: true,
                },
                "shipping_details[address]": {
                    required: true,
                },
                "shipping_details[postal_code]": {
                    required: true,
                },
                "shipping_details[city]": {
                    required: true,
                },
                "shipping_details[region]": {
                    required: true,
                }
            },
            messages: {
                "shipping_details[name]": "Please enter receiver's full name",
                "shipping_details[contact_no]": {
                    required: "Please enter receiver's contact no.",
                    maxlength: "Must be a valid contact no",
                    minlength: "Must be a valid contact no",
                },
                "shipping_details[email]": {
                    required: "Please enter receiver's email.",
                    email: "Must be a valid email",
                },
                "shipping_details[address]": {
                    required: "Please enter receiver's address.",
                    regex: "Must be a valid adress"
                },
                "shipping_details[apartment]": {
                    regex: "Must be a valid apartment, suite, etc."
                },
                "shipping_details[postal_code]": {
                    required: "Please enter city code",
                },
                "shipping_details[city]": {
                    required: "Please enter city",   
                },
                "shipping_details[region]": {
                    required: "Please enter region",
                },
            }, highlight: function(element) {
                $(element).addClass('is-invalid');
            }, unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    }   
    
    function proceedCheckoutPayment(){
        if($("#shippingDetailsForm").valid()){
            swal({
                icon:"question",
                title: 'Are you sure?',
                text: "Proceed to payment checkout",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }, function(result) {
                if (result) {
                    $("#shippingDetailsForm").submit();
                }
            });    
        }
    }

    function updateCartQty(){
        var data = {
            id        : $(this).data('id'),
            quantity  : $(this).val(),
            _token    : $('meta[name="csrf-token"]').attr('content')
        };

        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: baseURL + `res/cart/${$(this).data('id')}`,
            type: "put",
            data: data,
            success: function (response, status) {
                alertify.success("Cart successfully updated!");
                $("#cart").load(location.href + " #cartCont");
            },
            error: function (response) {
                alertify.error("Something went wrong");
            },
        });
    } 

    function deleteProdCart(){
        var id = $(this).data('id');
        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "This product will be removed from your cart",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }, function(result) {
            if (result) {
                var data = {
                    _token    : $('meta[name="csrf-token"]').attr('content')
                };
        
                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/cart/${id}`,
                    type: "delete",
                    data: data,
                    success: function (response, status) {
                        alertify.success("Cart successfully updated!");
                        $("#cart").load(location.href + " #cartCont");
                        $("#cartNav").load(location.href + " #cartNavCont");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
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
    Cart.init();
});
