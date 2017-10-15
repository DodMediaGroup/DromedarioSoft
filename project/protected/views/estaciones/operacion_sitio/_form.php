<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'operacion-sitio-form',
    'action'=>($model->isNewRecord)?($this->createUrl('estaciones/create_operacion_sitio__ajax').'?site='.$site->id):$this->createUrl('estaciones/update_operacion_sitio__ajax/'.$model->id),
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'class'=>'form__ajax',
        'role'=>'form',
        'method'=>'post',
        'data-form__redirect'=>($model->isNewRecord)?($this->createUrl('estaciones/create_mantenimientos').'?site='.$site->id):'',
    ),
)); ?>

    <div class="row" ng-app="organizacionOperacion">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Organización</strong> de la Operación</h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <?php
                        $model->site = $site->id;
                        echo $form->hiddenField($model,'site',array('required'=>true));
                    ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Producción del ultimo año</label>
                                <?php echo $form->numberField($model,'produccion_ultimo_anio',array('class'=>'form-control','min'=>0,'required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Número de días de trabajo al año</label>
                                <?php echo $form->numberField($model,'dias_trabajados_anio',array('class'=>'form-control','min'=>0,'max'=>365,'required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Jornada</strong> Laboral Sin Turnos</h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="text-center" style="display: block">MAÑANA</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>De</label>
                                        <?php echo $form->dropDownList($modelJornadasSinTurnos,'maniana_de',MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>A</label>
                                        <?php echo $form->dropDownList($modelJornadasSinTurnos,'maniana_a',MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="text-center" style="display: block">DESCANSO/ALMUERZO</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>De</label>
                                        <?php echo $form->dropDownList($modelJornadasSinTurnos,'descanso_de',MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>A</label>
                                        <?php echo $form->dropDownList($modelJornadasSinTurnos,'descanso_a',MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="text-center" style="display: block">TARDE</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>De</label>
                                        <?php echo $form->dropDownList($modelJornadasSinTurnos,'tarde_de',MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>A</label>
                                        <?php echo $form->dropDownList($modelJornadasSinTurnos,'tarde_a',MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Número de Trabajadores</label>
                                <?php echo $form->numberField($modelJornadasSinTurnos,'numero_trabajadores',array('class'=>'form-control','min'=>0,'required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Obseraciones</label>
                                <?php echo $form->textArea($modelJornadasSinTurnos,'observaciones',array('class'=>'form-control')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" ng-controller="jornadaLaboralTurnos">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Jornada</strong> Laboral Con Turnos</h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <div class="row" ng-if="forms.length > 0">
                        <div class="col-sm-12">
                            <table class="table" data-sortable>
                                <thead>
                                    <tr>
                                        <th width="75px">Turno No.</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Salida</th>
                                        <th width="100px">No. Trabajadores</th>
                                        <th width="40%">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="form in forms track by $index">
                                        <td style="vertical-align: middle;">{{ $index + 1 }}</td>
                                        <td style="vertical-align: middle;">
                                            <div class="form-group">
                                                <?php echo CHtml::dropDownList('SitesJornadasLaboralesTurnos[{{ $index }}][hora_entrada]',null,MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="form-group">
                                                <?php echo CHtml::dropDownList('SitesJornadasLaboralesTurnos[{{ $index }}][hora_salida]',null,MyMethods::doListHours(),array('class'=>'form-control','required'=>true)); ?>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="form-group">
                                                <?php echo CHtml::numberField('SitesJornadasLaboralesTurnos[{{ $index }}][numero_trabajadores]',null,array('class'=>'form-control','min'=>0,'required'=>true)); ?>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <div class="form-group">
                                                <?php echo CHtml::textArea('SitesJornadasLaboralesTurnos[{{ $index }}][observaciones]',null,array('class'=>'form-control')); ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <a ng-click="addForm()" class="btn btn-primary">Agregar Turno</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Paradas</strong></h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Número Paradas por Vacaciones Colectivas</label>
                                        <?php echo $form->numberField($model,'paradas_vacaciones',array('class'=>'form-control','min'=>0)); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <?php echo $form->textArea($model,'paradas_vacaciones_descripcion',array('class'=>'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Número Paradas por Otros Motivos al Año</label>
                                        <?php echo $form->numberField($model,'paradas_otras',array('class'=>'form-control','min'=>0)); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <?php echo $form->textArea($model,'paradas_otras_descripcion',array('class'=>'form-control')); ?>
                                    </div>
                                </div>
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