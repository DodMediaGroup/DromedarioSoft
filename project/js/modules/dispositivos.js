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
                    text: 'Counsumo (vatios)'
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
                    redraw: function(){
                        var series = this.series;
                        $.showDataDetail(series, '#live__total__data-detail');
                        console.log(series);
                    },
                    load: function () {
                        var series = this.series;
                        $.showDataDetail(series, '#live__total__data-detail');
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
                    text: 'Counsumo (vatios)'
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
                    text: 'Counsumo (vatios)'
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
                    text: 'Counsumo (vatios)'
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
                tickPixelInterval: 50,
                labels: {
                    format: '{value:%a %e %b}'
                }
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
                    pointFormat: '{point.x:%e %b, %Y} {point.y}:00: <b>{point.value} Vatios</b>'
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
                    pointFormat: '{point.x:%e %b, %Y} {point.y}:00: <b>{point.value} Vatios</b>'
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
                    text: 'Counsumo (vatios)'
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
                    text: 'Counsumo (vatios)'
                }
            }
        }
    }
};

$(document).on('ready', function(){
    $('#filter__date').on('click', function(){
        $.filterDataDate();
    });
});


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

$.filterDataDate = function(){
    var dateFrom = $('#filter__date__from').val(),
        dateTo = $('#filter__date__to').val();

    var query = '';

    if(dateFrom != '' || dateTo != ''){
        if(dateFrom != ''){
            dateFrom = moment(dateFrom, 'MM/DD/YYYY', true);
            if(dateFrom.isValid())
                query = '?from='+(dateFrom.valueOf() / 1000);
        }
        if(dateTo != ''){
            dateTo = moment(dateTo, 'MM/DD/YYYY', true);
            if(dateTo.isValid()){
                query += (query == '')?'?':'&';
                query += 'to='+(dateTo.valueOf() / 1000);
            }
        }
    }

    var link = $('#filter__date__url');
    link.attr('href', link.attr('href')+query);
    link[0].click();
};