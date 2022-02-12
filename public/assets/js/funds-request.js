let FundsRequest = (function () {
    let ui = {};
    let cashInTable,cashOutTable;

    function bindUi() {
        this._ui = {
            cashinTable: $('#cashInDataTable'),
            cashoutTable: $('#cashOutDataTable'),
            filter: $('.filter')
        };

        return _ui;
    }

    function bindEvents() {
        ui.cashinTable.on('click', 'tbody td', editCashIn);
        ui.cashoutTable.on('click', 'tbody td', editCashOut);
        ui.filter.on('change', filterDatatable);
        $('.request--btn').on('click', resetInput);
        $('.cash-in__approve').on('click', approveCashIn);
        $('.cash-out__approve').on('click', approveCashOut);
        $('.cash-in__decline').on('click', declineCashIn);
        $('.cash-out__decline').on('click', declineCashOut);
    } 

    function initializeFancybox(){
        $("a[data-fancybox='image']").fancybox();
    }
    function onLoad() {
        initializeCashInDatatable();
        initializeFancybox();
        initializeCashOutDatatable();
        initializeFormValidation();
    }

    function filterDatatable(){
        
        let array   = [];

        $('.filter').each(function(){
            let val     = $(this).val();
            let param   = $(this).data('sec');

            if(val != null){
                array.push(`${param}=${val}`);
            }
        });

        let filterParam = array.join('&');
        let cashin      = filterParam != '' ? `${window.cashin_url}&${filterParam}` : `${window.cashin_url}`;
        cashInTable.ajax.url(cashin).load();

        let cashout  = filterParam != '' ? `${window.cashout_url}&${filterParam}` : `${window.cashout_url}`;
        cashOutTable.ajax.url(cashout).load();
        
    }

    function initializeFormValidation(){
        $("#CashInForm").validate({
            rules: {
                'amount' : {
                    required : true,
                    minlength: 2,
                    number: true
                },
                'details[sender_name]' : {
                    required: true,
                },
                'details[mop]' : {
                    required: true,
                },
                'details[reference_no]' : {
                    required: true,
                    minlength: 6,
                }
            },
            messages: {
                'amount' : {
                    required : "Please enter your cash-in amount",
                    minlength: "Amount can't be less than 2 digits",
                    number: "Please enter a valid amount"
                },
                'details[sender_name]' : {
                    required : "Please enter your sender name",
                },
                'details[mop]' : {
                    required : "Please select your mode of payment",
                },
                'details[reference_no]' : {
                    required: "Please enter your reference/tracking #",
                    minlength:"Reference No. most be atleast 6 character long",
                }
            }    
        });
    }

    function initializeCashInDatatable(){
        cashInTable = ui.cashinTable.DataTable({
            "ajax": window.cashin_url,
            "columns": [
                { "data": "" },
                { "data": "details.sender_name" },
                { "data": "" },
                { "data": "details.mop" },
                { "data": "details.reference_no" },
                { "data": "" },
                { "data": "status_badge" },
                { "data": "date_sent" },
            ],  
            'columnDefs' : [
                {
                    'targets' : 0,
                    'render' : function ( url, type, full) {
                        return full['username'];
                    }
                },
                {
                    'targets' : 2,
                    'render' : function ( url, type, full) {
                        return full['amount_number_format'];
                    }
                },
                {
                    'targets' : 5,
                    'render' : function ( url, type, full) {
                        if(full['attachments'] != null){
                            return `<center><a data-fancybox="image" href="${full['attachments']}"><img height="50" width="50" class="img rounded cover" src="${full['attachments']}"></a></center>`;
                        }

                        return `<center><p class="text-muted">No Attachment</p></center>`;
                    }
                },
            ],
            'order' : [[7, 'desc']]
        });
    }

    function initializeCashOutDatatable(){
        cashOutTable = ui.cashoutTable.DataTable({
            "ajax": window.cashout_url,
            "columns": [
                { "data": "" },
                { "data": "details.receivers_name" },
                { "data": "amount_number_format" },
                { "data": "details.mot" },
                { "data": "details.account_no" },
                { "data": "status_badge" },
                { "data": "date_sent" },
            ],
            'columnDefs' : [
                {
                    'targets' : 0,
                    'render' : function ( url, type, full) {
                        return full['username'];
                    }
                },
            ]    
        } );
    }

    function editCashIn(){     
        let col = $(this).parent().children().index($(this));
        if(col != 5){
            let data = cashInTable.row($(this).parent()).data();
            $('#cashinModal').find('input[name="user"]').val(data.name_user);
            $('#cashinModal').find('input[name="details[sender_name]"]').val(data.details.sender_name);
            $('#cashinModal').find('input[name="details[reference_no]"]').val(data.details.reference_no);
            $('#cashinModal').find('input[name="amount"]').val(data.amount_number_format);
            $('#cashinModal').find('.cash-in--preview_prop').attr('href', data.attachments != null ? data.attachments : `${baseURL}/assets/images/default.png`);
            $('#cashinModal').find('.cash-in--preview_prop img').attr('src', data.attachments != null ? data.attachments : `${baseURL}/assets/images/default.png`);
            $('#cashinModal').find('.mop--details').text(data.details.mop);
            $('#cashinModal').find('.status--badge').html(data.status_badge);
            window.user_cashin = {
                type    : 'cashin',
                id      : data.id,
                user_id : data.user_id,
                amount  : data.amount,
                _token  :  $('meta[name="csrf-token"]').attr('content'),
                _method : 'PUT'
            };

            initializeFancybox();
            
            $('#cashinModal').modal('show');
        }
    }

    function editCashOut(){     
        let data = cashOutTable.row($(this).parent()).data();
        $('#cashoutModal').find('input[name="user"]').val(data.name_user);
        $('#cashoutModal').find('input[name="details[receivers_name]"]').val(data.details.receivers_name);
        $('#cashoutModal').find('input[name="details[account_no]"]').val(data.details.account_no);
        $('#cashoutModal').find('input[name="amount"]').val(data.amount_number_format);
        $('#cashoutModal').find('.mot--details').text(data.details.mot);
        $('#cashoutModal').find('.status--badge').html(data.status_badge);

        $('#cashoutModal').find('.cashout-sub__total').html(numberFormat(parseFloat(data.amount).toFixed(2).replace(/(\.0+|0+)$/, '')));
        $('#cashoutModal').find('.cashout-maintenance__fee').html(' - '+numberFormat(parseFloat(data.amount) * parseFloat(0.02)));
        $('#cashoutModal').find('.cashout-grand__total').html(numberFormat(parseFloat(data.amount) - (parseFloat(data.amount) * parseFloat(0.02))));
        window.user_cashout = {
            type    : 'cashout',
            id      : data.id,
            user_id : data.user_id,
            amount  : data.amount,
            _token  :  $('meta[name="csrf-token"]').attr('content'),
            _method : 'PUT'
        };
        
        $('#cashoutModal').modal('show');
   
    }

    function resetInput(){     
        $('#cashinModal').find('input[name="id"]').val('');
        $('#cashinModal').find('input[name="details[sender_name]"]').val('');
        $('#cashinModal').find('input[name="details[reference_no]"]').val('');
        $('#cashinModal').find('input[name="amount"]').val('');

        $('#cashinModal').modal('show');
    }

    function approveCashIn(){
        $('#cashinModal').modal('hide');
        Swal.fire({
            icon:"warning",
            title: 'Are you sure?',
            text: "This Cash-in request will be approve",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.isConfirmed) {
                window.user_cashin.response = 'approve';
                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/fund-request/${window.user_cashin.id}`,
                    type: "POST",
                    data: window.user_cashin,
                    success: function (response, status) {
                        cashInTable.ajax.reload();
                        alertify.success("Cash-in Successfully Approved");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        });    
    }

    function approveCashOut(){
        $('#cashoutModal').modal('hide');
        Swal.fire({
            icon:"warning",
            title: 'Are you sure?',
            text: "This Cash-out request will be approve",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.isConfirmed) {
                window.user_cashout.response = 'approve';
                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/fund-request/${window.user_cashout.id}`,
                    type: "POST",
                    data: window.user_cashout,
                    success: function (response, status) {
                        cashOutTable.ajax.reload();
                        alertify.success("Cash-out Successfully Approved");
                    },
                    error: function (response, status) {
                        if(response.status == 403){
                            alertify.error("User has not enough balance.");
                        }else{
                            alertify.error("Something went wrong");
                        }
                    },
                });
            }
        });    
    }

    function declineCashIn(){
        $('#cashinModal').modal('hide');
        Swal.fire({
            icon:"warning",
            title: 'Are you sure?',
            text: "This Cash-in request will be declined",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            input: 'textarea',
            inputAttributes: {
                autocapitalize: 'off',
                placeholder: 'Reason for declining ....'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.user_cashin.response = 'decline';
                window.user_cashin.reason   = result.value;
                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/fund-request/${window.user_cashin.id}`,
                    type: "POST",
                    data: window.user_cashin,
                    success: function (response, status) {
                        cashInTable.ajax.reload();
                        alertify.success("Cash-in Successfully declined");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        })
    }

    function declineCashOut(){
        $('#cashoutModal').modal('hide');
        Swal.fire({
            icon:"warning",
            title: 'Are you sure?',
            text: "This Cash-out request will be declined",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            input: 'textarea',
            inputAttributes: {
                autocapitalize: 'off',
                placeholder: 'Reason for declining ....'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.user_cashout.response = 'decline';
                window.user_cashout.reason   = result.value;
                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/fund-request/${window.user_cashout.id}`,
                    type: "POST",
                    data: window.user_cashout,
                    success: function (response, status) {
                        cashOutTable.ajax.reload();
                        alertify.success("Cash-out Successfully declined");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        })
    }

    function numberFormat(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
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
    FundsRequest.init();
});
