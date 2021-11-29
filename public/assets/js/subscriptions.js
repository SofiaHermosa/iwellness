let Subscriptions = (function () {
    let ui = {};

    function bindUi() {
        this._ui = {
            dataTable: $('#subscriptionDataTable'),
        };

        return _ui;
    }

    function bindEvents() {

    } 

    function onLoad() {
        initializeDatatable();
    }

    function initializeDatatable(){
        ui.dataTable.DataTable( {
            "ajax": window.url,
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
    Subscriptions.init();
});
