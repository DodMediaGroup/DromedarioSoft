var highChartsConf = {
    default: {
        legend: {
            enabled: false
        }
    },
    'highchart-live': function (highchart){
        return {
            chart: {
                type: 'spline',
                animation: Highcharts.svg,
                marginRight: 10,
                events: {
                    load: function () {
                        var series = this.series;
                        setInterval(function () {
                            var last = series[0].data[series[0].data.length - 1].x;
                            $.loadDataHighChart(highchart, function(json) {
                                for(var i = 0; i < json.length; i++){
                                    var serie = series[i];
                                    var data = json[i].data || [];
                                    for(var j = 0; j < data.length; j++){
                                        serie.addPoint(data[j], true, true);
                                    }
                                }
                            }, {last: last});
                        }, 10000);
                    }
                }
            },
            exporting: {
                enabled: false
            },
            title: {
                text: 'Consumo en vivo'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Counsumo (xx)'
                }
            }
        }
    },
    'highchart-live__moment': function(highchart){
        return {
            chart: {
                type: 'spline',
                animation: Highcharts.svg,
                marginRight: 10,
                events: {
                    load: function () {
                        var series = this.series;
                        setInterval(function () {
                            var last = series[0].data[series[0].data.length - 1].x;
                            $.loadDataHighChart(highchart, function(json) {
                                for(var i = 0; i < json.length; i++){
                                    var serie = series[i];
                                    var data = json[i].data || [];
                                    for(var j = 0; j < data.length; j++){
                                        serie.addPoint(data[j], true, false);
                                    }
                                }
                            }, {last: last, moment: series[0].data.length});
                        }, 10000);
                    }
                }
            },
            exporting: {
                enabled: false
            },
            title: {
                text: 'Tendencia de consumo en vivo'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Counsumo (xx)'
                }
            }
        }
    }
};

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
                options.series = json;
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
        $.createHighChartsChart(highchart, options);
    }
};

$.createHighChartsChart = function(highchart, options){
    HIGHCHARTS__list[highchart.attr('id')] = Highcharts.chart(highchart.attr('id'), options);
};