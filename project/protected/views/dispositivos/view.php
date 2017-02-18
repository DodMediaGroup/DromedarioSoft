<div class="page-heading">
	<h1>
		<i class='fa fa-gamepad'></i> Dispositivos 
		<small>- 
			<?php echo $dispositivo->nombre; ?>
			<?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
				[<?php echo $persona->nombre ?> <?php echo $persona->apellido ?>]
			<?php } ?>
		</small></h1>
	<h3>Detalles del dispositivo</h3>
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
                <highchart
                        id="highchart-live"
                        type="chart"
                        data__url="<?php echo $this->createUrl('dispositivos/getConsumoLive/'.$dispositivo->id); ?>"
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

<!--<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-header">
				<h2><strong>Consumo Live</strong> de <?php echo $dispositivo->nombre; ?></h2>
				<div class="additional-btn">
					<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
				</div>
			</div>
			<div class="widget-content padding">
				<highchart
					type="stockChart"
					data="<?php echo $dispositivo->id ?>"
					data__url="<?php echo $this->createUrl('dispositivos/getConsumoLive'); ?>"
					data__filter="corriente_1, corriente_2, corriente_3"
					live=""
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
				<h2><strong>Consumo</strong> de <?php echo $dispositivo->nombre; ?></h2>
				<div class="additional-btn">
					<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
				</div>
			</div>
			<div class="widget-content padding">
				<highchart
					type="stockChart"
					data="<?php echo $dispositivo->id ?>"
					data__url="<?php echo $this->createUrl('dispositivos/getConsumo'); ?>"
					data__filter="corriente_1, corriente_2, corriente_3"
					char__async-loading
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
					type="columnChart"
					data="<?php echo $dispositivo->id ?>"
					data__url="<?php echo $this->createUrl('dispositivos/getConsumoDays'); ?>"
					data__filter="corriente_1, corriente_2, corriente_3"
					char__async-loading
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
					type="columnChart"
					data="<?php echo $dispositivo->id ?>"
					data__url="<?php echo $this->createUrl('dispositivos/getConsumoHours'); ?>"
					data__filter="corriente_1, corriente_2, corriente_3"
					char__async-loading
				>
					
				</highchart>
			</div>
		</div>
	</div>
</div>-->