let ActivityLogs = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            dataTable: $(window.table),
        };

        return _ui;
    }

    function bindEvents() {
        
    } 

    function onLoad() {
        initializeDatatable();
    }

    function initializeDatatable(){
        let logs = [{ "data": "description" },
                     { "data": "date_sent" }];
        let sorting = [1, 'desc'];             

        if(window.table == "#adminLogsDataTable"){
            logs = [ { "data": "username" },
                     { "data": "description" },
                     { "data": "date_sent" }];
            sorting = [2, 'desc'];         
        }

        table = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": logs,
            'order' : [sorting]
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
    ActivityLogs.init();
});
