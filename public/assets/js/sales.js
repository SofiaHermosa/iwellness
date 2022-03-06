let Sales = (function () {
    let ui = {};
    let cards = '';

    function bindUi() {
        this._ui = {
            
        };

        return _ui;
    }

    function bindEvents() {
        $(document).on('change', '.date-filter', filterSales);
        $(document).on('click', '.previewSales', previewSales);
    } 

    function onLoad() {
        initializeDatepicker();
    }

    function initializeDatepicker(){
        $('.date-filter').daterangepicker();
    }

    function previewSales(){
        let data = JSON.parse(atob($(this).data('sales')));
      
        console.log(data);
        swal({
            title: 'Sales Analytics',
            html: true,
            text: `
            <div class="row">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                            <th class="text-left">User</th>
                            <th class="text-center">Level</th>
                            <th class="text-right">Activation</th>
                            <th class="text-right">Product Purchase</th>
                            <th class="text-right">Total</th>
                        </thead>
                        <tbody>
                            ${data}
                        </tbody>
                    </table>
                </div>
            </div>
            `,
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonText: 'Close',
            customClass: 'swal-wide',
        });
    }

    function filterSales(){
        var date = $(this).val();
        showLoading();
        if(date != ''){
            getSales(date);
        }
    }

    function getSales(date = null){
        $.get(window.sales_url, {date:date}).done(function(data){
            displayCards(data.data);
        });
    }

    function displayCards(data){
        cards = '';
        modal = '';

        $.each(data, function(key, data){
            var total = parseFloat(data['sales']['capital']) + parseFloat(data['sales']['orders']);
            var teams = '';
            var dataTeams = data.teams;
            dataTeams.sort(function(a,b){
                if(a.individual_sales.capital > b.individual_sales.capital){ return -1}
                if(a.individual_sales.capital < b.individual_sales.capital){ return 1}
                   return 0;
            });
            $.each(dataTeams, function(index, team){
                teams += `<tr>
                    <td class="text-left">${team.username}</td>
                    <td class="text-center">${team.level}</td>
                    <td class="text-right">${numberFormat(team.individual_sales.capital)}</td>
                    <td class="text-right">${numberFormat(team.individual_sales.orders)}</td>
                    <td class="text-right">${numberFormat(parseFloat(team.individual_sales.capital) + parseFloat(team.individual_sales.orders))}</td>
                </tr>`;
            })

            cards += `
            <div class="col-xxl-3 col-lg-6">
                <!-- Widget Linepoint -->
                <div class="card card-shadow" id="widgetLinepointDate">
                <div class="card-block p-30">
                    <div class="row">
                        <div class="col-md-8">
                            <span class="avatar avatar-team avatar-online w-full">
                                <img class="float-left mr-4" src="${data['supervisor'].prof_img}" alt="...">
                                <h3 class="card-title float-left mt-4">${data['supervisor'].name}</h3>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <div class="card-header-actions">
                                <span class="badge badge-dark badge-round p-1 px-2">${data['supervisor'].position}</span>
                            </div>
                        </div>
                    </div>
                    </h4>
                    <div class="row text-center my-25">
                    <div class="col-4">
                        <div class="counter counter-md">
                        <div class="counter-label font-size-12">TOTAL</div>
                        <div class="counter-number red-600">${numberFormat(total)}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="counter">
                        <div class="counter-label font-size-12">ACTIVATION</div>
                        <div class="counter-number red-600">${numberFormat(data['sales']['capital'])}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="counter">
                        <div class="counter-label font-size-12">PRODUCT PURCHASE</div>
                        <div class="counter-number red-600">${numberFormat(data['sales']['orders'])}</div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-lg-12 p-4 text-right">
                    <a href="javascript:void(0)" class="previewSales text-primary" data-sales="${btoa(JSON.stringify(teams))}">View Details <i class="icon fa-angle-right ml-1" aria-hidden="true"></i></a>
                </div>
                </div>
            </div>
            `;
        });

        $(document).find('#supervisor_sales').html(cards);
    }

    function showLoading(){
        var template = ` 
            <div class="page-content w-full mt-4 pt-4 text-center vertical-align-middle">
                <i class="icon fa-spinner icon-spin page-maintenance-icon font-size-60" aria-hidden="true"></i>
                <h2>Loading Analytics.....</h2>
            </div>`;
        
        $(document).find('#supervisor_sales').html(template);    
    }

    function numberFormat(number)
    {
        number = number.toString();
        const actualNumber = +number.replace(/,/g, '')
        const formatted = actualNumber.toLocaleString('en-US', {maximumFractionDigits: 2})

        return formatted;
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
    Sales.init();
});
