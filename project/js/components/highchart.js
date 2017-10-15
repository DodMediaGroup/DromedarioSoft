var HIGHCHARTS__list = {};

jQuery(document).ready(function($) {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    $('highchart').each(function(){
        var highchart = $(this);
        var options = {};

        if(highchart.is('[data__url]')){
            $.loadDataHighChart(highchart, function(json) {
                if(json.options)
                    options = json.options;
                else if(json.csv)
                    options.data = {csv: json.csv, lineDelimiter: ';'};
                else
                    options.series = json;

                if(highchart.is('[data-detail]'))
                    highchartLiveTotalData = JSON.parse(JSON.stringify(json));

                $.createHighChart(highchart, options);
            });
        }
        else
            $.createHighChart(highchart, options);
    });
});

$.loadDataHighChart = function(highchart, success, filter){
    var url = highchart.attr('data__url');
    filter = filter || {};
    if(highchart.is('[data__filter]'))
        filter.filter = $.trim(highchart.attr('data__filter'));
    if(highchart.is('[moment]'))
        filter.moment = filter.moment || true;

    $.getJSON(url, filter, success);
};

$.createHighChart = function(highchart, options){
    if(highchart.attr('type') == 'chart'){
        options = $.extend(highChartsConf[highchart.attr('id')](highchart), options);
        //console.log(options);
        $.createHighChartsChart(highchart, options);
    }
    else if(highchart.attr('type') == 'stockChart'){
        options = $.extend(highChartsConf[highchart.attr('id')](highchart), options);
        $.createHighChartsStockChart(highchart, options);
    }
};

$.createHighChartsChart = function(highchart, options){
    HIGHCHARTS__list[highchart.attr('id')] = Highcharts.chart(highchart.attr('id'), options);
};

$.createHighChartsStockChart = function(highchart, options){
    HIGHCHARTS__list[highchart.attr('id')] = Highcharts.stockChart(highchart.attr('id'), options);
};