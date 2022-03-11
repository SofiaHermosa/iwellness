let LoginBonus = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            dataTable: $('#loginBonusDataTable'),
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
            "ajax": window.loginBonusURL,
            "columns": [ 
                { "data": "subscription.complan_badge" },
                { "data": "" },
                { "data": "" },
                { "data": "date_sent" }
            ],
            "columnDefs" : [
                { 
                    'targets': 1 ,
                    'render' : function ( url, type, full) {
                        return numberFormat(full['subscription']['capital'][0]['amount']);
                    }
                },
                { 
                    'targets': 2 ,
                    'render' : function ( url, type, full) {
                        return numberFormat(full['properties']['attributes']['amount']);
                    }
                },
                {
                    'type': 'date', 
                    'targets': [3] 
                }
            ],
            'order' : [3, 'desc']
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
    LoginBonus.init();
});
