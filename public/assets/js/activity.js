let Logs = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            dataTable: $('#activityDataTable'),
        };

        return _ui;
    }

    function bindEvents() {
        
    } 

    function onLoad() {
        initializeDatatable();
    }

    function initializeDatatable(){
        table = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns":  [
                { "data": "activation_date"},
                { "data": "sched" },
                { "data": "" },
                { "data": "" },
                { "data": "release" },
                { "data": "" },
            ],
            'columnDefs' : [
                {
                    'targets' : 2,
                    'render' : function ( url, type, full) {
                        return full['survey'].length == 0 ? `` : `<i class="text-success wb-check text-center w--full"></i>`;
                    }
                },

                {
                    'targets' : 3,
                    'render' : function ( url, type, full) {
                        return full['logged_in'].length != 0 || full['ads'].length != 0 ? `<i class="text-success wb-check text-center w-full"></i>` : `` ;
                    }
                },

                {
                    'targets' : 5,
                    'render' : function ( url, type, full) {
                        return full['profit'].length == 0 ? `<span class='badge badge-lg badge-default'>Pending</span>` : `<span class='badge badge-lg badge-success'>Released</span>`;
                    }
                }
            ],   
            'order' : [[0, 'desc'], [4, 'asc']]
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
    Logs.init();
});
