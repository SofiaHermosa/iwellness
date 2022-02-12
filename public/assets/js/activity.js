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
                { "data": ""},
                { "data": "sched" },
                { "data": "" },
                { "data": "" },
                { "data": "release" },
            ],
            'columnDefs' : [
                {
                    'targets':0,
                    'type': 'date' 
                },
                {
                    'targets':5,
                    'type': 'date' 
                },
                {
                    'targets' : 1,
                    'render' : function ( url, type, full) {
                        return `<badge class="badge badge-lg ${full['plan_class']}">${full['plan']}</badge>`;
                    },
                    'type': 'date' 
                },
                {
                    'targets' : 3,
                    'render' : function ( url, type, full) {
                        return full['survey'].length == 0 ? `` : `<i class="text-success wb-check text-center w--full"></i>`;
                    }
                },

                {
                    'targets' : 4,
                    'render' : function ( url, type, full) {
                        return full['logged_in'].length != 0 || full['ads'].length != 0 ? `<i class="text-success wb-check text-center w-full"></i>` : `` ;
                    }
                },

                {
                    'targets' : 6,
                    'render' : function ( url, type, full) {
                        return full['profit'].length == 0 ? `<span class='badge badge-lg badge-default'>Pending</span>` : `<span class='badge badge-lg badge-success'>Released</span>`;
                    }
                },
            ], 
            'createdRow': function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class
                if(data.capital_release == true){
                    $( row ).find('td:eq(5)').addClass('release--date');
                    $( row ).addClass('release--date');
                }
            },  
            'order' : [[0, 'asc'], [1, 'asc'], [5, 'asc']]
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
