let ManageFunds = (function () {
    let ui = {};
    let cashInTable,cashOutTable;

    function bindUi() {
        this._ui = {
            cashinTable: $('#cashInDataTable'),
            cashoutTable: $('#cashOutDataTable'),
            subscriptionTable: $('#subscriptionsDataTable'),
            filter: $('.filter')
        };

        return _ui;
    }

    function bindEvents() {
        ui.cashinTable.on('click', 'tbody td', editCashIn);
        ui.cashoutTable.on('click', 'tbody td', previewCashOut);
        ui.filter.on('change', filterDatatable);
        $(document).on('click', '.upload--attachments',uploadAttachments);
        $(document).on('click', '.cashin--delete', deleteCashin);
        $(document).on('click', '.cashout--delete', deleteCashOut);
        $(document).on('click', '.dropdown-item', changeTabAction);
        $(document).on('click', '.nav-link', changeTabAction);
        $(document).on('click', '.edit--cashout', updateCashout);
        $(document).on('click', '.edit--cashin', function(){
            edit(window.cashin_details, '#cashinModal');
        });
        $('.cashout__amount').keyup(updateTotalCashout);
        $('#CashInForm').on('submit', function(){
            let id = $(this).find('input[name="id"]').val();

            if(id != ''){
                $("#CashInForm")[0].submit();
            }
        });
        $('.request--btn').on('click', resetInput);
    } 
    function changeTabAction(){
        var action = $(this).data('action');
        if(action !== 'disabled'){
            $('.request--btn').find('.btn--text').text(action);
        }

        if(action == 'Cash-in' && action !== null){
            window.modal__tab = '#cashinModal';
            $('.request--btn').find('.icon').addClass('fa-sign-in').removeClass('fa-sign-out fa-plus');
        }else if(action == 'Cash-out' && action !== null){
            window.modal__tab = '#cashoutModal';
            $('.request--btn').find('.icon').addClass('fa-sign-out').removeClass('fa-sign-in fa-plus');
        }else if(action !== 'disabled'){
            window.modal__tab = '#activateAccountModal';
            $('.request--btn').find('.icon').addClass('fa-plus').removeClass('fa-sign-in fa-sign-out');
        }

    }

    function updateTotalCashout(){
        let amount = $(this).val();
        let fee    = parseFloat(amount) * 0.02;
        let total  = parseFloat(amount) - parseFloat(fee);
        fee        = isNaN(fee) ? '00.00' : fee;
        total      = isNaN(total) ? '00.00' : total;

        $('#cashoutModal').find('.cashout-maintenance__fee').html(numberFormat(fee));
        $('#cashoutModal').find('.cashout-grand__total').html(numberFormat(total));
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
        let cashin      = filterParam != '' ? `${window.url}/cashin?${filterParam}` : `${window.url}/cashin`;
        cashInTable.ajax.url(cashin).load();

        let cashout  = filterParam != '' ? `${window.url}/cashout?${filterParam}` : `${window.url}/cashout`;
        cashOutTable.ajax.url(cashout).load();
        
    }
    function initializeFancybox(){
        $("a[data-fancybox='image']").fancybox({
            loop            : false,
            keyboard        : true,
            toolbar         : true,
            clickContent    : true,
            zoom            : true,
            hash            : false
        });
    }
    function onLoad() {
        initializeCashInDatatable();
        initializeFancybox();
        initializeCashOutDatatable();
        initializeSubscriptionsDatatable();
        initializeFormValidation();
    }

    function initializeFormValidation(){
        $("#CashInForm").validate({
            rules: {
                'amount' : {
                    required : true,
                    min: 500,
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
                    remote:`${baseURL}res/validate/cashin`
                }
            },
            messages: {
                'amount' : {
                    required : "Please enter your cash-in amount",
                    min: "Amount can't be less than 500",
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
                    remote: "Reference no. have used already"
                }
            }    
        });

        $("#CashOutForm").validate({
            rules: {
                'amount' : {
                    required : true,
                    min: 500,
                    max: 500000,
                    number: true
                },
                'details[receivers_name]' : {
                    required: true,
                },
                'details[mot]' : {
                    required: true,
                },
                'details[account_no]' : {
                    required: true,
                    minlength: 6,
                }
            },
            messages: {
                'amount' : {
                    required : "Please enter your cash-in amount",
                    min: "Amount can't be less than 500",
                    max: "Amount can't be greater than 500,000",
                    number: "Please enter a valid amount"
                },
                'details[receivers_name]' : {
                    required : "Please enter your sender name",
                },
                'details[mot]' : {
                    required : "Please select your mode of payment",
                },
                'details[account_no]' : {
                    required: "Please enter your account/phone no.",
                    minlength:"Account No. most be atleast 6 character long",
                }
            }    
        });
    }

    function initializeCashInDatatable(filter=null){
        cashInTable = ui.cashinTable.DataTable({
            "ajax": `${window.url}/cashin${filter != null ? `?${filter}` : ''}`,
            "columns": [
                { "data": "details.sender_name" },
                { "data": "" },
                { "data": "details.reference_no" },
                { "data": "" },
                { "data": "status_badge" },
                { "data": "date_sent" }
            ],  
            'columnDefs' : [
                {
                    'targets' : 1,
                    'render' : function ( url, type, full) {
                        return full['amount_number_format'];
                    }
                },
                {
                    'targets' : 3,
                    'render' : function ( url, type, full) {
                        if(full['attachments'] != null){
                            return `<center><a data-fancybox="image" href="${full['attachments']}"><img height="50" width="50" class="img rounded cover" src="${full['attachments']}"></a></center>`;
                        }

                        return `<center><button data-cashin="${window.btoa(unescape(encodeURIComponent(JSON.stringify(full))))}" class="btn btn-dark btn-xs upload--attachments">Upload Receipt</button></center>`;
                    }
                }
            ],
            'order' : [[5, 'desc']]
        });
    }

    function initializeCashOutDatatable(){
        cashOutTable = $('#cashOutDataTable').DataTable({
            "ajax": `${window.url}/cashout`,
            "columns": [
                { "data": "details.receivers_name" },
                { "data": "details.account_no" },
                { "data": "amount_number_format" },
                { "data": "status_badge" },
                { "data": "date_sent" }
            ],
            'order' : [[4, 'DESC']]
        });
    }

    function initializeSubscriptionsDatatable(){
        ui.subscriptionTable.DataTable( {
            "ajax": window.subscriptions,
            "columns": [
                { "data": "" },
                { "data": "" },
                { "data": "date_sent" },
                { "data": "valid_until" }
            ],
            'columnDefs' : [
                {
                    'targets' : 0,
                    'render' : function ( url, type, full) {
                        return `${numberFormat(full['capital'][0].amount)}`;
                    }
                },
                {
                    'targets' : 1,
                    'render' : function ( url, type, full) {
                        return full['release_dates'].join(', ');
                    }
                },
            ], 
            'order' : [[2, 'DESC']]
        } );
    }

    function uploadAttachments(){
        var data = JSON.parse(atob($(this).data('cashin')));
        edit(data);
    }

    function editCashIn(){     
        let col = $(this).parent().children().index($(this));
        if(col != 3){
            let data = cashInTable.row($(this).parent()).data();
            edit(data);
        }
    }

    function previewCashOut(){
        let data = cashOutTable.row($(this).parent()).data();
        window.cashout_details = data;
        editCashOut(data);
    }

    function updateCashout(){
        editCashOut(window.cashin_details, '#cashoutModal');
    }

    function editCashOut(data,modalType=null){
        var modal = '#cashoutStatusModal';
        if(modalType != null){
            modal = modalType;
            $('.modal').modal('hide');
        }

        $(modal).find('input[name="id"]').val(data.id).removeClass('error').addClass('focus');
        $(modal).find('input[name="details[receivers_name]"]').val(data.details.receivers_name).removeClass('error').addClass('focus');
        $(modal).find('select[name="details[mot]"]').val(data.details.mot ?? '').removeClass('error').addClass('focus');
        $(modal).find('input[name="details[account_no]"]').val(data.details.account_no).removeClass('error').addClass('focus');
        $(modal).find('input[name="amount"]').val(parseFloat(data.amount).toFixed(2).replace(/(\.0+|0+)$/, '')).removeClass('error').addClass('focus');
        $(modal).find('.status--badge').html(data.status_badge);
        $(modal).find('.cashout-sub__total').html(numberFormat(parseFloat(data.amount).toFixed(2).replace(/(\.0+|0+)$/, '')));
        $(modal).find('.cashout-maintenance__fee').html(' - '+numberFormat(parseFloat(data.amount) * parseFloat(0.02)));
        $(modal).find('.cashout-grand__total').html(numberFormat(parseFloat(data.amount) - (parseFloat(data.amount) * parseFloat(0.02))));
        if(modal == '#cashoutStatusModal'){
            $('.form-control').removeClass('focus');
        }

        $('.cashout--delete').fadeIn();
        window.cashin_details = data;

        if(data.status == 2){
            $('.reason--cont').fadeIn();
            $('.edit--cashout').fadeOut();
            $(modal).find('textarea[name="reason"]').val(atob(data.declining_reason));
        }else if(data.status == 0){
            $('.reason--cont').fadeOut();
            $('.edit--cashout').fadeIn();
            $(modal).find('textarea[name="reason"]').val('');
        }else{
            $('.reason--cont').fadeOut();
            $('.edit--cashout').fadeOut();
            $(modal).find('textarea[name="reason"]').val('');
        }
      
        $("#CashOutForm").valid();

        $(modal).modal('show');
    }

    function deleteCashin(){
        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "This cash-in request will be deleted",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }, function(result) {
            if (result) {
                var data = {
                    _token  :  $('meta[name="csrf-token"]').attr('content'),
                    _method : 'DELETE',
                    type    : 'cashin'
                }

                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/manage-funds/${window.cashin_details.id}`,
                    type: "DELETE",
                    data: data,
                    success: function (response, status) {
                        cashInTable.ajax.reload();
                        $('.modal').modal('hide');
                        alertify.success("Cash-in request successfully deleted!");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        });    
    }

    function deleteCashOut(){
        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "This cash-out request will be deleted",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }, function(result) {
            if (result) {
                var data = {
                    _token  :  $('meta[name="csrf-token"]').attr('content'),
                    _method : 'DELETE',
                    type    : 'cashout'
                }

                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/manage-funds/${window.cashin_details.id}`,
                    type: "DELETE",
                    data: data,
                    success: function (response, status) {
                        cashOutTable.ajax.reload();
                        $('.modal').modal('hide');
                        alertify.success("Cash-out request successfully deleted!");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        });    
    }

    function edit(data, modalType=null){
        var modal = '#cashinStatusModal';
        if(modalType != null){
            modal = modalType;
            $('.modal').modal('hide');
        }

        $(modal).find('input[name="id"]').val(data.id).removeClass('error').addClass('focus');
        $(modal).find('input[name="details[sender_name]"]').val(data.details.sender_name).removeClass('error').addClass('focus');
        $(modal).find('select[name="details[mop]"]').val(data.details.mop ?? '').removeClass('error').addClass('focus');
        $(modal).find('input[name="details[reference_no]"]').val(data.details.reference_no).removeClass('error').addClass('focus');
        $(modal).find('input[name="amount"]').val(parseFloat(data.amount).toFixed(2).replace(/(\.0+|0+)$/, '')).removeClass('error').addClass('focus');
        $(modal).find('input[name="current_attachment"]').val(data.prop).removeClass('error').addClass('focus');
        $(modal).find('.cash-in--preview_prop').attr('href', data.attachments != null ? data.attachments : `${baseURL}/assets/images/default.png`);
        $(modal).find('.cash-in--preview_prop img').attr('src', data.attachments != null ? data.attachments : `${baseURL}/assets/images/default.png`);
        $(modal).find('.status--badge').html(data.status_badge);
        $('.cashin--delete').fadeIn();
        window.cashin_details = data;
        
        if(modal == '#cashinStatusModal'){
            $('.form-control').removeClass('focus');
        }


        if(data.status == 2){
            $('.reason--cont').fadeIn();
            $('.edit--cashin').fadeOut();
            $(modal).find('textarea[name="reason"]').val(atob(data.declining_reason));
        }else if(data.status == 0){
            $('.reason--cont').fadeOut();
            $('.edit--cashin').fadeIn();
            $(modal).find('textarea[name="reason"]').val('');
        }else{
            $('.reason--cont').fadeOut();
            $('.edit--cashin').fadeOut();
            $(modal).find('textarea[name="reason"]').val('');
        }
      
        $("#CashInForm").valid();

        $(modal).modal('show');
    }

    function resetInput(){  
        var target = window.modal__tab ?? '#cashinModal';   

        $(target).find('input[name="id"]').val('').removeClass('focus');
        $(target).find('input[name="details[sender_name]"]').val('').removeClass('focus');
        $(target).find('input[name="details[reference_no]"]').val('').removeClass('focus');
        $(target).find('select[name="details[mop]"]').val('').removeClass('focus');
        $(target).find('input[name="amount"]').val('').removeClass('focus');

        $('.cashin--delete').fadeOut();
        $(target).modal('show');
    }

    function numberFormat(number)
    {
        number = number.toString();
        const actualNumber = +number.replace(/,/g, '')
        const formatted = actualNumber.toLocaleString('en-US', {maximumFractionDigits: 2})

        return formatted
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
    ManageFunds.init();
});
