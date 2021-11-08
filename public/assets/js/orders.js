let Orders = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            dataTable: $('#ordersDataTable'),
            btn_delivered: $('.btn--delivered'),
            form: $('#orderInvoiceForm')
        };

        return _ui;
    }

    function bindEvents() {
        ui.dataTable.on('click', 'tbody tr', edit);
        ui.btn_delivered.on('click', tagAsDelivered);
    } 

    function onLoad() {
        initializeDatatable();
    }

    function tagAsDelivered(){
        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "This order will be tag as delivered",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }, function(result) {
            if (result) {
                ui.form.submit();
            }
        });    
    }
    function initializeDatatable(){
        table = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": [
                { "data": "user.name" },
                { "data": "ordered_list" },
                { "data": "order_contact" },
                { "data": "full_address" },
                { "data": "status_badge" },
                { "data": "order_date" }
            ]
        } );
    }

    function edit(){     
        let data = table.row(this).data();

        window.location.href = `${baseURL}res/order/invoice/${data.id}`;
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
    Orders.init();
});
