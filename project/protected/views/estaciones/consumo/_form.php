<style type="text/css">
    .widget table tr td{
        padding-left: 6px;
        padding-right: 6px;
    }
</style>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'operacion-sitio-form',
    'action'=>($model->isNewRecord)?($this->createUrl('estaciones/create_consumo__ajax').'?site='.$site->id):$this->createUrl('estaciones/update_consumo__ajax/'.$model->id),
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'class'=>'form__ajax',
        'role'=>'form',
        'method'=>'post',
        'data-form__redirect'=>($model->isNewRecord)?($this->createUrl('estaciones/create_estado_inicial').'?site='.$site->id):'',
    ),
)); ?>

    <div class="row" ng-app="organizacionOperacion">
        <div class="col-md-12" ng-controller="consumo">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Información</strong> Sobre Suministro de Energéticos</h2>
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
                        <div class="col-xs-12">
                            <div class="alert alert-info">
                                El siguiente cuadro solicita información sobre los energéticos primarios de la empresa. Se busca que la información consignada refleje los costos y consumos del ÚLTIMO AÑO. La información será utilizada para la realización de la Matríz Energética.
                            </div>
                        </div>
                    </div>
                    <?php foreach ($energeticos as $key=>$energetico){
                        $ngModel = 'energetico_'.$energetico->id;
                    ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="data-table-toolbar">
                                    <div class="form-horizontal">
                                        <div class="row">
                                            <label class="col-sm-3 control-label"><?php echo $energetico->nombre ?></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" ng-model="<?php echo $ngModel; ?>">
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
                                            <label>Consumo</label>
                                            <div class="input-group">
                                                <input name="SitesConsumosEnergeticos[energetico_<?php echo $energetico->id ?>][consumo]" type="number" min="0" class="form-control" required>
                                                <span class="input-group-addon"><?php echo $energetico->unidad; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Precio Actual Unidad</label>
                                            <input name="SitesConsumosEnergeticos[energetico_<?php echo $energetico->id ?>][precio_unidad]" type="number" min="0" value="0" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <label>Consumo Unidades Energéticas</label>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <?php foreach ($nomMeses as $key=>$mes){ ?>
                                                        <th><?php echo $mes; ?></th>
                                                    <?php } ?>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach ($nomMeses as $key=>$mes){ ?>
                                                        <td><input ng-model="consumo_<?php echo $energetico->id ?>[<?php echo $key ?>]" name="SitesConsumosEnergeticos[energetico_<?php echo $energetico->id ?>][meses][mes_<?php echo $key+1; ?>]" type="number" min="0" class="form-control" value="0" placeholder="<?php echo $energetico->unidad; ?>"></td>
                                                    <?php } ?>
                                                    <td>
                                                        <input type="text" min="0" class="form-control" disabled value="{{ sumatoria(consumo_<?php echo $energetico->id ?>) }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
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