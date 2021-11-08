let DiamondConversion = (function () {
    let ui = {};
    let conversionTable;

    function bindUi() {
        this._ui = {
            dataTable: $('#requestDataTable'),
        };

        return _ui;
    }

    function bindEvents() {
        ui.dataTable.on('click', 'tbody td', viewDetails);
        $(document).on('click', '.conversion__delete', deleteConversion);
        $(document).on('click', '.diamond-conversion__card', requestConversion);
        $('#conversionRequestForm').on('submit', submitRequest);
    } 

    function onLoad() {
        initializeDatatable();
    }

    function initializeDatatable(){
        conversionTable = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": [
                { "data": "item.name" },
                { "data": "details.receivers_name" },
                { "data": "details.contact_no" },
                { "data": "status_badge" },
                { "data": "date_sent" },
            ] 
        } );
    }

    function requestConversion(){
        var item = JSON.parse(atob($(this).data('item')));
    
        swal({
            icon:"info",
            title: 'Convert Diamonds?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
        }, function(result) {
            if (result) {
                viewItemConversion(item);
            }
        });    
    }

    function viewItemConversion(item){
        $('#conversionRequestModal').find('.item--img').attr('src', item.attachments != null ? item.attachments : `${baseURL}/assets/images/default.png`);
        $('#conversionRequestModal').find('.item--name').text(item.name);
        $('#conversionRequestModal').find('input[name="item_id"]').val(item.id);
        $('#conversionRequestModal').modal('show');
    }

    function deleteConversion(){
        $('.modal').modal('hide');
        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "This diamond conversion request will be deleted",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }, function(result) {
            if (result) {
                window.conversion._method = 'DELETE';

                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: baseURL + `res/diamond/conversion/${window.conversion.id}`,
                    type: "DELETE",
                    data: window.conversion,
                    success: function (response, status) {
                        conversionTable.ajax.reload();
                        $('.modal').modal('hide');
                        alertify.success("Diamond conversion request successfully deleted!");
                    },
                    error: function (response) {
                        alertify.error("Something went wrong");
                    },
                });
            }
        });    
    }

    function viewDetails(){
        let data = conversionTable.row($(this).parent()).data();
          
        window.conversion = {
            id      : data.id,
            _token  :  $('meta[name="csrf-token"]').attr('content'),
            _method : 'PUT'
        };

        if(data.status == 2){
            $('#conversionModal').find('.reason--cont').fadeIn();
            $('.reason--cont').find('textarea[name="reason"]').val(data.declining_reason);
        }else{
            $('#conversionModal').find('.reason--cont').fadeOut();
            $('.reason--cont').find('textarea[name="reason"]').val("");
        }

        $('#conversionModal').find('input[name="user"]').val(data.user.name);
        $('#conversionModal').find('input[name="receivers_name"]').val(data.details.receivers_name);
        $('#conversionModal').find('textarea[name="address"]').val(data.full_address);
        $('#conversionModal').find('input[name="phone"]').val(data.details.contact_no);
        $('#conversionModal').find('.item--details').text(data.item.name);
        $('#conversionModal').find('.status--badge').html(data.status_badge);
        $("#conversionModal").find('.conversion--preview_prop').attr('href', data.item.attachments != null ? data.item.attachments : `${baseURL}/assets/images/default.png`);
        $("#conversionModal").find('.conversion--preview_prop img').attr('src', data.item.attachments != null ? data.item.attachments : `${baseURL}/assets/images/default.png`);

        $('#conversionModal').modal('show');
    }
    
    function submitRequest(e){
        e.preventDefault()

        $('.modal').modal('hide');

        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "Item price will be deducted to your current diamond balance",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }, function(result) {
            if (result) {
                const data = new FormData(e.target);

                const value = Object.fromEntries(data.entries());

                $.ajaxSetup({
                    headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
        
                $.ajax({
                    url: $('#conversionRequestForm').attr('action'),
                    type: "POST",
                    data: value,
                    success: function (response, status) {
                        conversionTable.ajax.reload();
                        $('.modal').modal('hide');
                        alertify.success("Diamond conversion request successfully sent!");
                    },
                    error: function (response) {
                        alertify.error("Not enough diamonds");
                    },
                });
            }
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
    DiamondConversion.init();
});
