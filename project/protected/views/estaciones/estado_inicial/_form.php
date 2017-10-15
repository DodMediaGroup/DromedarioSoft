<style type="text/css">
    .widget table tr td{
        padding-left: 6px;
        padding-right: 6px;
    }
</style>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'operacion-sitio-form',
    'action'=>($model->isNewRecord)?($this->createUrl('estaciones/create_estado_inicial__ajax').'?site='.$site->id):$this->createUrl('estaciones/update_estado_inicial__ajax/'.$model->id),
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'class'=>'form__ajax',
        'role'=>'form',
        'method'=>'post',
        'data-form__redirect'=>($model->isNewRecord)?($this->createUrl('estaciones/create_censo_carga').'?site='.$site->id):'',
    ),
)); ?>

<div class="row" ng-app="organizacionOperacion">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Registre</strong> si la empresa tiene (o no) información sobre los siguientes ítems</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <?php
                    $model->site = $site->id;
                    echo $form->hiddenField($model,'site',array('required'=>true));
                ?>

                <?php foreach ($items as $key=>$item){
                    $ngModel = 'item_'.$item->id;
                ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="data-table-toolbar">
                                <div class="form-horizontal">
                                    <div class="row">
                                        <label class="col-sm-9 control-label" style="text-align: left;"><?php echo $item->item ?></label>
                                        <div class="col-sm-3">
                                            <select name="SitesEstadosInicialesItems[item_<?php echo $item->id ?>][item]" class="form-control" ng-model="<?php echo $ngModel; ?>">
                                                <option value="">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" ng-if="<?php echo $ngModel; ?> == 1">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Responsable</label>
                                        <input name="SitesEstadosInicialesItems[item_<?php echo $item->id ?>][responsable]" type="text" maxlength="255" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Ubicación (archivos, departamentos, sistemas de información, etc.)</label>
                                        <input name="SitesEstadosInicialesItems[item_<?php echo $item->id ?>][ubicacion]" type="text" maxlength="255" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Observaciones</label>
                                        <input name="SitesEstadosInicialesItems[item_<?php echo $item->id ?>][observaciones]" type="text" maxlength="255" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-12" ng-controller="estadoInicial">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Sistemas</strong> de Información</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <div class="row" ng-if="sistemasInformacion.length > 0">
                    <div class="col-sm-12">
                        <table class="table" data-sortable>
                            <thead>
                            <tr>
                                <th width="90px">Item No.</th>
                                <th>Sistema de Información</th>
                                <th>Descripción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="form in sistemasInformacion track by $index">
                                <td style="vertical-align: middle;">{{ $index + 1 }}</td>
                                <td>
                                    <?php echo CHtml::textField('SitesEstadosInicialesSistemasInf[{{ $index }}][nombre]',null,array('class'=>'form-control','required'=>true)); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::textField('SitesEstadosInicialesSistemasInf[{{ $index }}][descripcion]',null,array('class'=>'form-control','required'=>true)); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a ng-click="addSistemaInformacionForm()" class="btn btn-primary">Agregar Sistema Información</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Descripción</strong> de los contratos energéticos de la empresa (Contrato Regulado, Contrato No Regulado, etc.)</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <?php echo $form->textArea($model,'contratos_energeticos',array('class'=>'js-ckeditor')); ?>
            </div>
        </div>
    </div>

    <div class="col-md-12" ng-controller="estadoInicial">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Describa</strong> los sistemas de medicion de energía de la empresa</h2>
                <div class="additional-btn">
                    <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                </div>
            </div>
            <div class="widget-content padding">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-info">
                            Medidores internos  y fronteras comerciales que actualmente tiene la empresa (Energía Eléctrica, Gas, Combustibles Líquidos, Energéticos Secundarios, etc.)
                        </div>
                    </div>
                </div>

                <div class="row" ng-if="sistemasMedicion.length > 0">
                    <div class="col-sm-12">
                        <table class="table" data-sortable>
                            <thead>
                            <tr>
                                <th width="90px">Item No.</th>
                                <th>Sistema de Medición</th>
                                <th>Área Cubierta</th>
                                <th>Ubicación</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="form in sistemasMedicion track by $index">
                                <td style="vertical-align: middle;">{{ $index + 1 }}</td>
                                <td>
                                    <?php echo CHtml::textField('SitesEstadosInicialesSistemasMedicion[{{ $index }}][nombre]',null,array('class'=>'form-control','required'=>true,'maxlength'=>155)); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::textField('SitesEstadosInicialesSistemasMedicion[{{ $index }}][areas_cubiertas]',null,array('class'=>'form-control','required'=>true)); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::textField('SitesEstadosInicialesSistemasMedicion[{{ $index }}][ubicacion]',null,array('class'=>'form-control','required'=>true,'maxlength'=>155)); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a ng-click="addSistemaMedicionForm()" class="btn btn-primary">Agregar Sistema Información</a>
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