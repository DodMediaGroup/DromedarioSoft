<style type="text/css">
    .widget table tr td{
        padding-left: 6px;
        padding-right: 6px;
    }
</style>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'censo-carga-form',
    'action'=>($model->isNewRecord)?($this->createUrl('estaciones/create_censo_carga__ajax').'?site='.$site->id):$this->createUrl('estaciones/update_censo_carga__ajax/'.$model->id),
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'class'=>'form__ajax',
        'role'=>'form',
        'method'=>'post',
        'data-form__redirect'=>($model->isNewRecord)?$this->createUrl('estaciones/admin'):'',
    ),
)); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-info">
            Este formato tiene como objetivo realizar el Diagrama de Pareto por <strong>ENERGÉTICO PRIMARIO</strong> (Energía Eléctrica, Gas Natural, Carbón y Combustibles Líquidos) de las diferentes áreas y equipos de la empresa.
        </div>
    </div>
</div>

<div class="row" ng-app="organizacionOperacion">
    <div class="col-md-12" ng-controller="censoCarga">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Censo</strong> de Carga</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <?php
                    $model->site = $site->id;
                    echo $form->hiddenField($model,'site',array('required'=>true));
                ?>


                <div ng-repeat="form in forms track by $index">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Tipo de Energético</label>
                                <select name="SitesCensoEnergeticos[{{ $index }}][energetico]" class="form-control" required>
                                    <option value="">--- Seleccione una opción ---</option>
                                    <?php foreach ($energeticos as $key=>$energetico){ ?>
                                        <option value="<?php echo $energetico->id; ?>"><?php echo $energetico->nombre.' ('.$energetico->unidad.')'; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Area</label>
                                <input name="SitesCensoEnergeticos[{{ $index }}][area]" type="text" class="form-control" maxlength="65" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Equipo</label>
                                <input name="SitesCensoEnergeticos[{{ $index }}][equipo]" type="text" class="form-control" maxlength="65" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input name="SitesCensoEnergeticos[{{ $index }}][cantidad]" type="number" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Horas de uso equivalentes a plena carga/dia</label>
                                <input name="SitesCensoEnergeticos[{{ $index }}][horas_uso_dia]" type="number" class="form-control" min="0" max="24" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Dias de uso/mes</label>
                                <input name="SitesCensoEnergeticos[{{ $index }}][dias_uso_mes]" type="number" class="form-control" min="0" max="31" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Energia consumida mes</label>
                                <input name="SitesCensoEnergeticos[{{ $index }}][energia_mes]" type="number" class="form-control" min="0" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a ng-click="addForm()" class="btn btn-primary">Agregar Equipo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar y Continuar' : 'Guardar', array('class'=>'btn btn-success')); ?>
            <a href="<?php echo $this->createUrl('estaciones/admin'); ?>" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>