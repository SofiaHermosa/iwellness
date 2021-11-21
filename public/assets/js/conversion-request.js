let ConversionRequest = (function () {
    let ui = {};
    let conversionTable;

    function bindUi() {
        this._ui = {
            dataTable: $('#requestDataTable'),
        };

        return _ui;
    }

    function bindEvents() {
        ui.dataTable.on('click', 'tbody td', viewDetails);
        $('.conversion__approve').on('click', approveConversion);
        $('.conversion__decline').on('click', declineConversion);
    } 

    function onLoad() {
        initializeDatatable();
    }

    function initializeDatatable(){
        conversionTable = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": [
                { "data": "user.username" },
                { "data": "item.name" },
                { "data": "status_badge" },
                { "data": "date_sent" },
            ],
            'order' : [[3, 'desc']]
        } );
    }

    function approveConversion(){
        $('#conversionModal').modal('hide');
        Swal.fire({
            icon:"warning",
            title: 'Are you sure?',
            text: "This diamond conversion request will be approve",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.isConfirmed) {
                window.conversion.action = 'approve';
                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/diamond/conversion/request/${window.conversion.id}`,
                    type: "POST",
                    data: window.conversion,
                    success: function (response, status) {
                        conversionTable.ajax.reload();
                        alertify.success("Diamond conversion request successfully approved");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        });    
    }

    function declineConversion(){
        $('#conversionModal').modal('hide');
        Swal.fire({
            icon:"warning",
            title: 'Are you sure?',
            text: "This diamond conversion request will be decline",
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
                window.conversion.action = 'decline';
                window.conversion.reason   = result.value;
                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/diamond/conversion/request/${window.conversion.id}`,
                    type: "POST",
                    data: window.conversion,
                    success: function (response, status) {
                        conversionTable.ajax.reload();
                        alertify.success("Diamond conversion request successfully declined");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        });    
    }

    function viewDetails(){
        let data = conversionTable.row($(this).parent()).data();
          
        window.conversion = {
            id      : data.id,
            _token  :  $('meta[name="csrf-token"]').attr('content'),
            _method : 'PUT'
        };

        $('#conversionModal').find('input[name="user"]').val(data.user.name);
        $('#conversionModal').find('input[name="receivers_name"]').val(data.details.receivers_name);
        $('#conversionModal').find('textarea[name="address"]').val(data.details.full_address);
        $('#conversionModal').find('input[name="phone"]').val(data.details.contact_no);
        $('#conversionModal').find('.item--details').text(data.item.name);
        $('#conversionModal').find('.status--badge').html(data.status_badge);
        $("#conversionModal").find('.conversion--preview_prop').attr('href', data.item.attachments != null ? data.item.attachments : `${baseURL}/assets/images/default.png`);
        $("#conversionModal").find('.conversion--preview_prop img').attr('src', data.item.attachments != null ? data.item.attachments : `${baseURL}/assets/images/default.png`);

        $('#conversionModal').modal('show');
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
    ConversionRequest.init();
});
