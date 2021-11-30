let Items = (function () {
    let ui = {};
    let table;

    function bindUi() {
        this._ui = {
            editor: $('#description--editor'),
            dataTable: $('#dataTable'),
            btn_delete: $('.btn--archive'),
            addToCartBtn: $('.add--to_cart'),
            prodId: $('#itemId'),
            prodQty: $('#itemQty'),
            updtQty: $('.updtQuantity'),
            prodPrice: $('.item--price'),
            discountPrice: $('.discount--price')
        };

        return _ui;
    }

    function bindEvents() {
        ui.dataTable.on('click', 'tbody tr', edit);
        ui.btn_delete.on('click', archive);
        ui.addToCartBtn.on('click', addToCart);
        ui.updtQty.on('click', updateQuantity);
        ui.prodQty.on('change', updatePrice);
    } 

    function onLoad() {
        initializeSummernote();
        initializeDatatable();
    }

    function initializeSummernote(){
        ui.editor.summernote({
            height: 250,
        });
    }

    function initializeDatatable(){
        table = ui.dataTable.DataTable( {
            "ajax": window.url,
            "columns": [
                { "data": "" },
                { "data": "price" },
            ],
            'columnDefs' : [
                {
                    'targets' : 0,
                    'render' : function ( url, type, full) {
                        return `${full['cover']} <span class="mr-10">${full['name']}</span>`;
                    }
                }
            ]    
        } );
    }

    function updateQuantity(){
        var operation = $(this).data('ops');
        var current   = parseInt(ui.prodQty.val());

        if(operation){
            ui.prodQty.val(current + 1)
        }else{
            var diff = current - 1;
            if(diff <= 0){
                diff = 1
            }
            ui.prodQty.val(diff)
        }

        updatePrice();
    }

    function updatePrice(){
        var current        = parseFloat(ui.prodQty.val());
        var price          = parseFloat($('#price').val());
        var discounted     = parseFloat($('#discounted').val());

        ui.prodPrice.html(price * current);
        ui.discountPrice.html(discounted * current);
    }

    function addToCart(){
        var data = {
            id        : ui.prodId.val(),
            quantity  : ui.prodQty.val(),
            _token    : $('meta[name="csrf-token"]').attr('content')
        };

        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: baseURL + "res/cart",
            type: "post",
            data: data,
            success: function (response, status) {
                $("#cartNav").load(location.href + " #cartNavCont");
                alertify.success("Product Successfully added to cart!");
            },
            error: function (response) {
                alertify.error("Something went wrong");
            },
        });

    }
    function edit(){     
        let data = table.row(this).data();

        window.location.href = `${baseURL}res/diamond/conversion/items/${data.id}/edit`;
    }

    function archive(){     
        let target = $(this).data('form');

        swal({
            icon:"warning",
            title: 'Are you sure?',
            text: "This item will be deleted",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }, function(result) {
            if (result) {
               $(target).submit();
            } 
        })
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
    Items.init();
});
