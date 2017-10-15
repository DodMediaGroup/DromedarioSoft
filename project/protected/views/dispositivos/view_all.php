<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo Total Live</strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <div class="row">
                    <div class="col-sm-9">
                        <highchart
                            id="highchart-live__total"
                            type="chart"
                            data__url="<?php echo $this->createUrl('dispositivos/getConsumoLiveTotal/'.$dispositivo->id); ?>"
                            data-detail
                        >

                        </highchart>
                    </div>
                    <div id="live__total__data-detail" class="col-sm-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo Live</strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <div class="row">
                    <div class="col-sm-9">
                        <highchart
                            id="highchart-live"
                            type="chart"
                            data__url="<?php echo $this->createUrl('dispositivos/getConsumoLive/'.$dispositivo->id); ?>"
                            data__filter="corriente_1, corriente_2, corriente_3"
                        >

                        </highchart>
                    </div>
                    <div id="live__data-detail" class="col-sm-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /*
<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Tendencia de Consumo Live</strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                    id="highchart-live__moment"
                    type="chart"
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoLive/'.$dispositivo->id); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                    moment
                >

                </highchart>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Tendencia de Consumo Total </strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                    id="highchart-total__moment"
                    type="stockChart"
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoTotal/'.$dispositivo->id); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                    moment
                >

                </highchart>
            </div>
        </div>
    </div>
</div>
*/ ?>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo ultimo dia </strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                        id="highchart-day__last"
                        type="chart"
                        data__url="<?php echo $this->createUrl('dispositivos/getConsumoLastDay/'.$dispositivo->id); ?>"
                        data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo ultima semana </strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                        id="highchart-week__last__line"
                        type="chart"
                        data__url="<?php echo $this->createUrl('dispositivos/getConsumoLastWeekLine/'.$dispositivo->id); ?>"
                        data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
            <div class="widget-content padding">
                <highchart
                    id="highchart-week__last"
                    type="chart"
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoLastWeek/'.$dispositivo->id); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo ultimo mes completo </strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                        id="highchart-month__last__line"
                        type="chart"
                        data__url="<?php echo $this->createUrl('dispositivos/getConsumoLastMonthLine/'.$dispositivo->id); ?>"
                        data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
            <div class="widget-content padding">
                <highchart
                    id="highchart-month__last"
                    type="chart"
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoLastMonth/'.$dispositivo->id); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo</strong> de <?php echo $dispositivo->nombre; ?> por dias de la semana</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                    id="highchart-days"
                    type="chart"
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoDays/'.$dispositivo->id); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo</strong> de <?php echo $dispositivo->nombre; ?> por horas del dia</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                    id="highchart-hours"
                    type="chart"
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoHours/'.$dispositivo->id); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Reporte Economico </strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                        id="highchart-consumo-economico"
                        type="chart"
                        data__url="<?php echo $this->createUrl('dispositivos/getConsumoEconomico/'.$dispositivo->id); ?>"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>