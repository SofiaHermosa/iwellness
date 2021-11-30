let Network = (function () {
    let ui = {};

    function bindUi() {
        this._ui = {
            dataTable: $('#dataTable'),
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
                { "data": "name" },
                { "data": "username" },
                { "data": "subscrip_status"},
                { "data": "level"},
                { "data": ""},
            ],
            'columnDefs' : [
                {
                    'targets' : 4,
                    'render' : function ( url, type, full) {
                        return `${numberFormat(full['commission'])}`;
                    }
                },
            ],    
            'order' : [[3, 'asc']]
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
    Network.init();
});
