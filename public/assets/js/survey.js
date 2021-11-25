let Survey = (function () {
    let ui          = {};
    let table;

    function bindUi() {
        this._ui = {
            dataTable: $('#surveyDataTable'),
        };

        return _ui;
    }

    function bindEvents() {
    
    } 

    function onLoad() {
        initializeTable();
    }


    function initializeTable(){
        table = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": [
                {"data" : "question"},
                { "data": "choices" },
                { "data": "date_sent" },
            ],
            'order' : [[2, 'desc']]   
        });
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
    Survey.init();
});
