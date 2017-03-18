<div class="row top-summary">
    <div class="col-lg-3 col-md-6">
        <div class="widget green-1 animated fadeInDown">
            <a href="<?php echo $this->createUrl('estaciones/admin'); ?>" class="widget-content padding">
                <div class="widget-icon">
                    <i class="fa fa-building-o"></i>
                </div>
                <div class="text-box">
                    <p class="maindata">TOTAL <b>ESTACIONES</b></p>
                    <h2><span class="animate-number" data-value="<?php echo count($estaciones); ?>" data-duration="1000">0</span></h2>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="widget darkblue-2 animated fadeInDown">
            <div class="widget-content padding">
                <div class="widget-icon">
                    <i class="icon-flash-2"></i>
                </div>
                <div class="text-box">
                    <p class="maindata">TOTAL <b>DISPOSITIVOS</b></p>
                    <h2><span class="animate-number" data-value="<?php echo count($dispositivos); ?>" data-duration="1000">0</span></h2>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="widget orange-4 animated fadeInDown">
            <div class="widget-content padding">
                <div class="widget-icon">
                    <i class="icon-chart-line"></i>
                </div>
                <div class="text-box">
                    <p class="maindata">TOTAL <b>CONSUMO</b></p>
                    <h2><span class="animate-number" data-value="<?php echo number_format(($consumo['consumo'] / 1000), 2,'.',''); ?>" data-duration="3000">0</span> Kw</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget darkblue-3">
            <div class="widget-header transparent">
                <h2><strong>Huella</strong> Ecologica</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    <a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
                </div>
            </div>
            <div class="widget-content">
                <div id="website-statistic2" class="statistic-chart">

                    <div class="col-sm-12 stacked">
                        <h4><i class="fa fa-leaf text-green-1"></i> Huella Ecologica</h4>
                        <div class="col-sm-12 status-data">

                            <div class="col-xs-12">
                                <div class="row stacked">
                                    <div class="col-xs-3 text-center right-border">
                                        Agua Hidroeléctrica (Lts)<br>
                                        <span class="animate-number" data-value="<?php echo number_format(($consumo['consumo'] / 1000) * 200,1,'.',''); ?>" data-duration="3000">0</span>
                                    </div>
                                    <div class="col-xs-3 text-center right-border">
                                        Agua Termoeléctrica (Lts)<br>
                                        <span class="animate-number" data-value="<?php echo number_format(($consumo['consumo'] / 1000) * 84.5,1,'.',''); ?>" data-duration="3000">0</span>
                                    </div>
                                    <div class="col-xs-3 text-center right-border">
                                        C02 Termoeléctrica (Kg)<br>
                                        <span class="animate-number" data-value="<?php echo number_format(($consumo['consumo'] / 1000) * 0.53,1,'.',''); ?>" data-duration="3000">0</span>
                                    </div>
                                    <div class="col-xs-3 text-center">
                                        Carbón Termoeléctrica (Kg)<br>
                                        <span class="animate-number" data-value="<?php echo number_format(($consumo['consumo'] / 1000) * 0.476,1,'.',''); ?>" data-duration="3000">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                </div>
            </div>
            <div class="widget-footer bg-green-1 padding">
                <div class="row">
                    <div class="col-sm-12">
                        <div style="padding: 6px 12px;">
                            <i class="fa fa-leaf rel-change"></i> Como reducir mi huella ecologica
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>