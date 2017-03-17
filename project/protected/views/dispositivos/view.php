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
    <div class="col-xs-12">
        <a class="btn btn-danger" href="<?php echo $this->createUrl('estaciones/'.$dispositivo->estacion); ?>">Atras</a>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-content padding">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-md-offset-2">
                        <?php
                            $dateFrom = '';
                            if(isset($dateFilter['from']))
                                $dateFrom = gmdate("m/d/Y", $dateFilter['from']);
                        ?>
                        <label for="filter__date__from" class="control-label">Fecha desde</label>
                        <input type="text" value="<?php echo $dateFrom; ?>" id="filter__date__from" class="form-control datepicker-input">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php
                        $dateTo = '';
                        if(isset($dateFilter['to']))
                            $dateTo = gmdate("m/d/Y", $dateFilter['to']);
                        ?>
                        <label for="filter__date__to" class="control-label">Fecha hasta</label>
                        <input type="text" value="<?php echo $dateTo; ?>" id="filter__date__to" class="form-control datepicker-input">
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <button class="btn btn-primary" type="button" id="filter__date">Filtrar</button>
                    </div>
                    <a id="filter__date__url" href="<?php echo $this->createUrl('dispositivos/'.$dispositivo->id); ?>" class="hidden"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    if($dateFilter == null) {
        $this->renderPartial('view_all', array(
            'dispositivo' => $dispositivo,
            'persona' => $persona
        ));
    }
    else{
        $this->renderPartial('view_filter', array(
            'dispositivo' => $dispositivo,
            'persona' => $persona,

            'dateFilter' => $dateFilter
        ));
    }
?>