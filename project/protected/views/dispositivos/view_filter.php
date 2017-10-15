<?php
    if(isset($dateFilter['to']) && $dateFilter['from'])
        $datesDiff = ($dateFilter['to'] - $dateFilter['from']) / (60 * 60 * 24) + 1;
    else{
        if(!isset($dateFilter['from'])){
            $first = MyMethods::querySql('select 
                UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) as fecha
                FROM registros
                WHERE
                    dispositivo = '.$dispositivo->id.'
                order by fecha ASC
                limit 1;');
            $datesDiff = ($dateFilter['to'] - $first[0]['fecha']) / (60 * 60 * 24) + 1;
        }
        if(!isset($dateFilter['to'])){
            $last = MyMethods::querySql('select 
                UNIX_TIMESTAMP(date_format(fecha, "%Y-%m-%d")) as fecha
                FROM registros
                WHERE
                    dispositivo = '.$dispositivo->id.'
                order by fecha DESC
                limit 1;');
            $datesDiff = ($last[0]['fecha'] - $dateFilter['from']) / (60 * 60 * 24) + 1;
        }
    }
?>

<div class="row top-summary">
    <div class="col-lg-3 col-md-6">
        <div class="widget green-1 animated fadeInDown">
            <div class="widget-content padding">
                <div class="widget-icon">
                    <i class="icon-chart-line"></i>
                </div>
                <div class="text-box">
                    <p class="maindata">TOTAL <b>CONSUMO</b></p>
                    <h2><span class="animate-number" data-value="<?php echo number_format(($dateFilter['registro'][0]['total'] / 1000), 2,'.',''); ?>" data-duration="3000">0</span> Kw</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="widget darkblue-2 animated fadeInDown">
            <div class="widget-content padding">
                <div class="widget-icon">
                    <i class="icon-flash-2"></i>
                </div>
                <div class="text-box">
                    <p class="maindata">FASE <b>1</b></p>
                    <h2><span class="animate-number" data-value="<?php echo number_format(($dateFilter['registro'][0]['corriente_1'] / 1000), 2,'.',''); ?>" data-duration="3000">0</span> Kw</h2>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="widget orange-4 animated fadeInDown">
            <div class="widget-content padding">
                <div class="widget-icon">
                    <i class="icon-flash-2"></i>
                </div>
                <div class="text-box">
                    <p class="maindata">FASE <b>2</b></p>
                    <h2><span class="animate-number" data-value="<?php echo number_format(($dateFilter['registro'][0]['corriente_2'] / 1000), 2,'.',''); ?>" data-duration="3000">0</span> Kw</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="widget lightblue-1 animated fadeInDown">
            <div class="widget-content padding">
                <div class="widget-icon">
                    <i class="icon-flash-2"></i>
                </div>
                <div class="text-box">
                    <p class="maindata">FASE <b>3</b></p>
                    <h2><span class="animate-number" data-value="<?php echo number_format(($dateFilter['registro'][0]['corriente_3'] / 1000), 2,'.',''); ?>" data-duration="3000">0</span> Kw</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Consumo Total </strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <div class="row">
                    <div class="col-sm-9">
                        <highchart
                                id="highchart-filter__total"
                                type="stockChart"
                                data__url="<?php echo $this->createUrl('dispositivos/getConsumoLiveTotal/'.$dispositivo->id.$dateFilter['query']); ?>"
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
                <h2><strong>Consumo </strong> de <?php echo $dispositivo->nombre; ?></h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <highchart
                    id="highchart-total__moment"
                    type="stockChart"
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoTotal/'.$dispositivo->id.$dateFilter['query']); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>

<?php if($datesDiff >= 7){ ?>
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
                        data__url="<?php echo $this->createUrl('dispositivos/getConsumoDays/'.$dispositivo->id.$dateFilter['query']); ?>"
                        data__filter="corriente_1, corriente_2, corriente_3"
                    >

                    </highchart>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

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
                    data__url="<?php echo $this->createUrl('dispositivos/getConsumoHours/'.$dispositivo->id.$dateFilter['query']); ?>"
                    data__filter="corriente_1, corriente_2, corriente_3"
                >

                </highchart>
            </div>
        </div>
    </div>
</div>