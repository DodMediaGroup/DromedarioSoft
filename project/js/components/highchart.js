var HIGHCHARTS__list = [];

jQuery(document).ready(function($) {
	$("highchart").each(function(index, el) {
		if(!$(this).is('[id]'))
			$(this).attr('id', ('highchart__' + index));

		$.createChar($(this));
	});
});

$(function () {
	var currentTime = new Date();
	
	Highcharts.setOptions({
        global: {
            //timezoneOffset: currentTime.getTimezoneOffset()
            useUTC: false
        }
    });
});

$.createChar = function(highchart){
	var type = highchart.attr('type');
	var dataUrl = highchart.attr('data__url');
	var data = highchart.attr('data').split(",");
	var filters = '';

	var seriesOption = [];
	var seriesCounter = 0;

	if(highchart.is('[data__filter]') && $.trim(highchart.attr('data__filter')) != ''){
		filters = $.trim(highchart.attr('data__filter'));
	}

	$.each(data, function(index, val) {
		var dataAjax = {
			id: val
		};
		if(filters != '')
			dataAjax.filter = filters;

		$.getJSON(dataUrl, dataAjax, function(json, textStatus) {
			seriesOption = seriesOption.concat(json);
			seriesCounter++;

			if(seriesCounter >= data.length){
				if(type == 'stockChart')
					$.createStockChart(highchart, seriesOption);
				else if(type == 'columnChart')
					$.createColumnChart(highchart, seriesOption);
			}
		});
	});
}


$.createStockChart = function(highchart, series){
	var chartOptions = {
		rangeSelector: {
            selected: 1
        },
		title: {
            text: ((highchart.is('[title]') && highchart.attr('title') != '')?highchart.attr('title'):'')
        },
        tooltip: {
            valueDecimals: 2,
        },
        series: series,
	}

	if(highchart.is('[live]')){
		chartOptions.rangeSelector = {
			buttons: [{
                count: 10,
                type: 'minute',
                text: '10M'
            }, {
                count: 30,
                type: 'minute',
                text: '30M'
            }, {
                type: 'all',
                text: 'All'
            }],
            inputEnabled: false,
            selected: 0
		}
	}
	if(highchart.is('[char__async-loading]')){
		var charIndex = HIGHCHARTS__list.length;
		chartOptions.xAxis = {
			events: {
                afterSetExtremes: function(e){
                	$.afterSetExtremes(highchart, charIndex, e);
                }
            }
		};
		chartOptions.navigator = {
            adaptToUpdatedData: false,
            series: {
                data: series.data
            }
        };
        chartOptions.scrollbar = {
            liveRedraw: false
        };
	}


	var chart = Highcharts.stockChart(highchart.attr('id'), chartOptions);
	HIGHCHARTS__list.push(chart);

    if(highchart.is('[live]')){
    	setInterval(function(){
            $.loadSincCharData(highchart, chart, series);
        }, 10000);
    }
}

$.createColumnChart = function(highchart, options){
	var chartOptions = options[0];
	
	chartOptions['chart'] = {
        type: 'column'
	};
	chartOptions['tooltip'] = {
		headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			'<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
		footerFormat: '</table>',
		shared: true,
		useHTML: true
	};

	var chart = Highcharts.chart(highchart.attr('id'), chartOptions);
	HIGHCHARTS__list.push(chart);
}

$.loadSincCharData = function(highchart, chart, series){
	var dataUrl = highchart.attr('data__url');
	var data = highchart.attr('data').split(",");
	var filters = '';

	if(highchart.is('[data__filter]') && $.trim(highchart.attr('data__filter')) != ''){
		filters = $.trim(highchart.attr('data__filter'));
	}

	var seriesOption = [];
	var seriesCounter = 0;
	$.each(data, function(index, val) {
		var dataSerie = series[index].data;
		var dataAjax = {
			id: val,
		}
		if(dataSerie.length > 0){
			var last = dataSerie[dataSerie.length - 1];
			dataAjax.last = last[0];
		}
		if(filters != '')
			dataAjax.filter = filters;
		
		$.getJSON(dataUrl, dataAjax, function(json, textStatus) {
			seriesOption = seriesOption.concat(json);
			seriesCounter++;

			if(seriesCounter == data.length){
				$.each(seriesOption, function(sOIndex, sOVal) {
					$.each(sOVal.data, function(sODIndex, sODVal) {
						chart.series[sOIndex].addPoint(sODVal, true, true);
					});
				});
			}
		});
	});
}
$.afterSetExtremes = function(highchart, indexChar, e){
	var chart = Highcharts.charts[indexChar];
    chart.showLoading('Loading data from server...');

    var dataUrl = highchart.attr('data__url');
	var data = highchart.attr('data').split(",");
	var filters = '';

	var seriesOption = [];
	var seriesCounter = 0;

	if(highchart.is('[data__filter]') && $.trim(highchart.attr('data__filter')) != ''){
		filters = $.trim(highchart.attr('data__filter'));
	}

	$.each(data, function(index, val) {
		var dataAjax = {
			id:val,
			start:Math.round(e.min),
			end:Math.round(e.max)
		}
		if(filters != '')
			dataAjax.filter = filters;

		$.getJSON(dataUrl, dataAjax, function(json, textStatus) {
			seriesOption = seriesOption.concat(json);
			seriesCounter++;

			if(seriesCounter >= data.length){
				$.each(seriesOption, function(sOIndex, sOVal) {
					chart.series[sOIndex].setData(sOVal.data);
				});

				chart.hideLoading();
			}
		});
	});
}