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
                { "data": "activated" },
                { "data": "level" },
                { "data": "commission" }
            ],
            'order' : [[3, 'asc']]
        } );
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
