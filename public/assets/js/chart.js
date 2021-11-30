(function () {
    var data = JSON.parse(atob($(document).find('#fundData').data('funds')));
    new Chartist.Line('#fundRequestChart .ct-chart', {
        labels: data[0],
        series: [data[1], data[2]]
    }, {
        low: 0,
        showArea: true,
        showPoint: false,
        showLine: false,
        fullWidth: true,
        chartPadding: {
            top: 0,
            right: 10,
            bottom: 0,
            left: 0
        },
        axisX: {
            showGrid: false,
            labelOffset: {
                x: -14,
                y: 0
            }
        },
        axisY: {
            labelInterpolationFnc: function labelInterpolationFnc(num) {
                return abbreviateNumber(num);
            }
        }
    });
})();

(function () {
    var pending  = atob($(document).find('#CashinData').data('pending'));
    var approved = atob($(document).find('#CashinData').data('approved'));
    var declined = atob($(document).find('#CashinData').data('declined'));
    var status   = ['pending', 'approved', 'declined'];
    var data     = [pending, approved, declined];
    var total    = parseFloat(pending, 2) + parseFloat(approved) + parseFloat(declined,2);
    $.each(status, function(key, val){
        var result = parseFloat(data[key] * 100)/ parseFloat(total);
        $(`.counter-cashin-${val}`).text(`${result.toFixed(2)}%`);
    });

    new Chartist.Pie('#chartPieCashin .ct-chart', {
        series: [pending,  declined, approved]
    }, {
        donut: true,
        donutWidth: 10,
        startAngle: 0,
        showLabel: false
    });
})();

(function () {
    var cashout_pending  = atob($(document).find('#CashoutData').data('pending'));
    var cashout_approved = atob($(document).find('#CashoutData').data('approved'));
    var cashout_declined = atob($(document).find('#CashoutData').data('declined'));
    var cashout_status   = ['pending', 'approved', 'declined'];
    var cashout_data     = [cashout_pending, cashout_approved, cashout_declined];
    var cashout_total    = parseFloat(cashout_pending, 2) + parseFloat(cashout_approved) + parseFloat(cashout_declined,2);
    $.each(cashout_status, function(key, val){
        var result = parseFloat(cashout_data[key] * 100)/ parseFloat(cashout_total);
        $(`.counter-cashout-${val}`).text(`${result.toFixed(2)}%`);
    });

    new Chartist.Pie('#chartPieCashout .ct-chart', {
        series: [cashout_approved,cashout_pending,cashout_declined]
    }, {
        donut: true,
        donutWidth: 10,
        startAngle: 0,
        showLabel: false
    });
})();

function abbreviateNumber(value) {
    var newValue = value;
    if (value >= 1000) {
        var suffixes = ["", "k", "m", "b","t"];
        var suffixNum = Math.floor( (""+value).length/3 );
        var shortValue = '';
        for (var precision = 2; precision >= 1; precision--) {
            shortValue = parseFloat( (suffixNum != 0 ? (value / Math.pow(1000,suffixNum) ) : value).toPrecision(precision));
            var dotLessShortValue = (shortValue + '').replace(/[^a-zA-Z 0-9]+/g,'');
            if (dotLessShortValue.length <= 2) { break; }
        }
        if (shortValue % 1 != 0)  shortValue = shortValue.toFixed(1);
        newValue = shortValue+suffixes[suffixNum];
    }
    return newValue;
}