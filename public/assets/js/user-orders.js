let UserOrders = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            dataTable: $('#userOrdersDataTable'),
        };

        return _ui;
    }

    function bindEvents() {
        ui.dataTable.on('click', 'tbody tr', edit);
    } 

    function onLoad() {
        initializeDatatable();
    }

    function initializeDatatable(){
        table = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": [
                { "data": "order_id" },
                { "data": "ordered_list" },
                { "data": "order_contact" },
                { "data": "full_address" },
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
    UserOrders.init();
});
