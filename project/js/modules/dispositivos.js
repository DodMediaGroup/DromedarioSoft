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
                        $.showDataDetailTotalLive(highchartLiveTotalData, '#live__total__data-detail');
                    },
                    load: function () {
                        var series = this.series;
                        $.showDataDetailTotalLive(highchartLiveTotalData, '#live__total__data-detail');
                        setInterval(function () {
                            var last = highchartLiveTotalData[0].data[highchartLiveTotalData[0].data.length - 1].x;
                            $.loadDataHighChart(highchart, function(json) {
                                for(var i = 0; i < json.length; i++){
                                    var serie = series[i];
                                    var data = json[i].data || [];
                                    for(var j = 0; j < data.length; j++){
                                        highchartLiveTotalData[i].data.push(data[j]);
                                        serie.addPoint($.formatPointValue(data[j]), true, true);
                                    }
                                    //$.reDrawDataDetailTotalLive(serie);
                                }
                            }, {last: last});
                        }, 10000);

                        $.initControlDetailTotalLive(series[0]);
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
                marginRight: 10
            },
            exporting: {
                enabled: true
            },
            legend: {
                enabled: true
            },
            title: {
                text: 'Consumo total'
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
    'highchart-day__last': function(highchart){
        return {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Consumo último día'
            },
            yAxis: {
                title: {
                    text: 'Corriente (A)'
                }
            }
        }
    },
    'highchart-week__last__line': function(highchart){
        return {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Consumo última semana'
            },
            yAxis: {
                title: {
                    text: 'Corriente (A)'
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
                    [0, '#aaeeff'],
                    [0.5, '#fffbbc'],
                    [1, '#c4463a']
                ],
                min: 0
            },
            series: [{
                borderWidth: 0,
                colsize: 24 * 36e5,
                tooltip: {
                    headerFormat: 'Consumo<br/>',
                    pointFormat: '{point.y}:00: <b>{point.value} Vatios</b>'
                }
            }]
        }
    },
    'highchart-month__last__line': function(highchart){
        return {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Consumo último mes'
            },
            yAxis: {
                title: {
                    text: 'Corriente (A)'
                }
            }
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
                    [0, '#aaeeff'],
                    [0.5, '#fffbbc'],
                    [1, '#c4463a']
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
    },

    'highchart-filter__total': function(highchart){
        return {
            chart: {
                animation: Highcharts.svg,
                marginRight: 10,
                events: {
                    redraw: function(){
                        $.showDataDetailTotalLive(highchartLiveTotalData, '#live__total__data-detail');
                    },
                    load: function () {
                        var series = this.series;
                        $.showDataDetailTotalLive(highchartLiveTotalData, '#live__total__data-detail');
                        $.initControlDetailTotalLive(series[0]);
                    }
                }
            },
            exporting: {
                enabled: false
            },
            legend: {
                enabled: true
            },
            title: {
                text: 'Consumo total'
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
    'highchart-consumo-economico': function(highchart){
        return {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Consumo económico'
            },
            yAxis: {
                title: {
                    text: 'Pesos ($)'
                }
            }
        }
    }
};
var highchartLiveTotalData = null;
var highchartLiveTotalDataType = 'corriente';




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

$.showDataDetailTotalLive = function(series, container){
    container = $(container);

    $.each(series, function(index, serie){
        var last = serie.data[serie.data.length - 1].y;

        var contentId = container.attr('id')+'-serie_'+index;
        var itemsSelect = [
            {id:'corriente',name:'Corriente (A)'},
            {id:'energia',name:'Energia (Kw/h)'},
            {id:'precio',name:'Precio ($)'}];

        if(!$('#'+contentId).length){
            var newContent = $('<div>',{class:'text-right'}).attr('id', contentId);

            $.each(itemsSelect, function(key, value){
                if(key != 0)
                    newContent.append($('<hr>'));

                var newItem = $('<a>', {class:('total-live__item-select '+((highchartLiveTotalDataType==value.id)?'active':''))}).attr({
                    'data-select': value.id
                })
                    .append($('<h5>').html(value.name))
                    .append($('<h1>', {text: '0'}));
                newContent.append(newItem);
            });

            container.append(newContent);
        }

        $('#'+contentId).find('[data-select="corriente"] h1').text(last.toFixed(2));
        $('#'+contentId).find('[data-select="energia"] h1').text($.calcCorrienteToEnergia(last).toFixed(2));
        $('#'+contentId).find('[data-select="precio"] h1').text($.calcCorrienteToPrecio(last).toFixed(2));
    });
};
$.reDrawDataDetailTotalLive = function(serie){
    for(var i = 0; i < highchartLiveTotalData.length; i++){
        var newSerie = [];
        for(var j = 0; j < highchartLiveTotalData[i].data.length; j++){
            newSerie.push($.formatPointValue(highchartLiveTotalData[i].data[j]));
        }
        serie.setData(newSerie);
    }
};
$.formatPointValue = function(point){
    return {
        x: point.x,
        y: $.pointToDataTypeSelect(point.y)
    };
};

$.initControlDetailTotalLive = function(serie){
    $(document).on('click', '.total-live__item-select', function(){
        highchartLiveTotalDataType = $(this).attr('data-select');
        $('.total-live__item-select').removeClass('active');
        $(this).addClass('active');
        $.reDrawDataDetailTotalLive(serie);
    });
};

$.filterDataDate = function(){
    var dateFrom = $('#filter__date__from').val(),
        dateTo = $('#filter__date__to').val();

    var query = '';

    if(dateFrom != '' || dateTo != ''){
        if(dateFrom != ''){
            dateFrom = moment(dateFrom, 'MM/DD/YYYY H:mm', true);
            if(dateFrom.isValid())
                query = '?from='+(dateFrom.valueOf() / 1000);
        }
        if(dateTo != ''){
            dateTo = moment(dateTo, 'MM/DD/YYYY H:mm', true);
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

$.calcCorrienteToEnergia = function(corriente){
    var energia = (corriente * dispositivoVoltaje) / 1000;
    return energia;
};
$.calcEnergiaToPrecio = function(energia){
    var precio = energia * dispositivoValorKw;
    return precio;
};
$.calcCorrienteToPrecio = function(corriente){
    return $.calcEnergiaToPrecio($.calcCorrienteToEnergia(corriente));
};
$.pointToDataTypeSelect = function(value){
    if(highchartLiveTotalDataType == 'energia')
        return $.calcCorrienteToEnergia(value);
    if(highchartLiveTotalDataType == 'precio')
        return $.calcCorrienteToPrecio(value);
    return value;
};