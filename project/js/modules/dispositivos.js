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
                    redraw: function(){
                        var series = this.series;
                        $.showDataDetail(series, '#live__data-detail');
                    },
                    load: function () {
                        var series = this.series;
                        $.showDataDetail(series, '#live__data-detail');
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
    'highchart-live__total': function(highchart){
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
                text: 'Consumo total en vivo'
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
    },
    'highchart-total__moment': function(highchart) {
        return {
            chart: {
                animation: Highcharts.svg,
                marginRight: 10,
            },
            exporting: {
                enabled: true
            },
            legend: {
                enabled: true
            },
            title: {
                text: 'Tendencia de consumo total'
            },
            tooltip: {
                valueDecimals: 4
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
    'highchart-week__last': function(highchart){
        return {
            chart: {
                type: 'heatmap',
                inverted: true
            },
            exporting: {
                enabled: true
            },
            title: {
                text: 'Consumo última semana'
            },
            xAxis: {
                tickPixelInterval: 50
            },
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    format: '{value}:00'
                },
                minPadding: 0,
                maxPadding: 0,
                startOnTick: false,
                endOnTick: false,
                tickWidth: 1,
                min: 0,
                max: 23
            },
            colorAxis: {
                stops: [
                    [0, '#fffbbc'],
                    [0.9, '#c4463a']
                ],
                min: 0
            },
            series: [{
                borderWidth: 0,
                colsize: 24 * 36e5,
                tooltip: {
                    headerFormat: 'Consumo<br/>',
                    pointFormat: '{point.x:%e %b, %Y} {point.y}:00: <b>{point.value} XX</b>'
                }
            }]
        }
    },
    'highchart-month__last': function(highchart){
        return {
            chart: {
                type: 'heatmap'
            },
            exporting: {
                enabled: true
            },
            title: {
                text: 'Consumo último mes'
            },
            xAxis: {
                tickPixelInterval: 50
            },
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    format: '{value}:00'
                },
                minPadding: 0,
                maxPadding: 0,
                startOnTick: false,
                endOnTick: false,
                tickWidth: 1,
                min: 0,
                max: 23,
                reversed: true
            },
            colorAxis: {
                stops: [
                    [0, '#fffbbc'],
                    [0.9, '#c4463a']
                ],
                min: 0
            },
            series: [{
                borderWidth: 0,
                colsize: 24 * 36e5,
                tooltip: {
                    headerFormat: 'Consumo<br/>',
                    pointFormat: '{point.x:%e %b, %Y} {point.y}:00: <b>{point.value} XX</b>'
                }
            }]
        }
    },
    'highchart-days': function(highchart){
        return {
            chart: {
                type: 'column'
            },
            exporting: {
                enabled: true
            },
            title: {
                text: 'Consumo por dias'
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            yAxis: {
                title: {
                    text: 'Counsumo (xx)'
                }
            }
        }
    },
    'highchart-hours': function(highchart){
        return {
            chart: {
                type: 'column'
            },
            exporting: {
                enabled: true
            },
            title: {
                text: 'Consumo por horas'
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
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
                if(json.options)
                    options = json.options;
                else if(json.csv)
                    options.data = {csv: json.csv, lineDelimiter: ';'};
                else
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



$.showDataDetail = function(series, container){
    container = $(container);

    $.each(series, function(index, serie){
        var last = serie.data[serie.data.length - 1].y;

        var contentId = container.attr('id')+'-'+serie['name'];
        var exist = $('#'+contentId).length;

        if(exist){
            var valueContent = $('#'+contentId).find('h1');
            valueContent.text(last);
        }
        else{
            var titleContent = 'Consumo Actual <span>'+serie['name']+'</span>';
            var newContent = $('<div>',{class:'text-right'});
            newContent
                .attr('id', contentId)
                .append($('<h5>').html(titleContent))
                .append($('<h1>', {text: last}));

            container.append(newContent);
            if(index < (serie.data.length - 2))
                container.append($('<hr>'));
        }
    });
};