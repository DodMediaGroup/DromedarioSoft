<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'operacion-sitio-form',
    'action'=>($model->isNewRecord)?($this->createUrl('estaciones/create_mantenimientos__ajax').'?site='.$site->id):$this->createUrl('estaciones/update_mantenimientos__ajax/'.$model->id),
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'class'=>'form__ajax',
        'role'=>'form',
        'method'=>'post',
        'data-form__redirect'=>($model->isNewRecord)?($this->createUrl('estaciones/create_consumo').'?site='.$site->id):'',
    ),
)); ?>

    <div class="row" ng-app="organizacionOperacion" ng-controller="mantenimientos">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Datos</strong> Referentes al Mantenimiento</h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                                $model->site = $site->id;
                                echo $form->hiddenField($model,'site',array('required'=>true));
                            ?>
                            <div class="form-group">
                                <label>La empresa realiza algun tipo de mantenimiento periodico?</label>
                                <select ng-model="activar" class="form-control">
                                    <option value="">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-if="activar == 1">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo de mantenimiento</label>
                                <?php echo $form->dropDownList($modelRegistro,'tipo',MyMethods::getListSelect('MantenimientosTipos','id','nombre'),array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Frecuencia</label>
                                <?php echo $form->dropDownList($modelRegistro,'frecuencia',array(''=>'--- Seleccione una opción ---','Nunca'=>'Nunca','Mensual'=>'Mensual','Trimestral'=>'Trimestral','Anual'=>'Anual'),array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Describa el procedimiento de mantenimiento en la empresa</label>
                                <?php echo $form->textArea($modelRegistro,'descripcion',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" ng-if="activar == 1">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Datos</strong> Persona Responsable</h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <div class="row">
                        <div class="col-sm-7 col-xs-12">
                            <div class="form-group">
                                <label>Responsable</label>
                                <?php echo $form->textField($modelResponsable,'nombre',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label>Cargo</label>
                                <?php echo $form->dropDownList($modelResponsable,'cargo',MyMethods::getListSelect('CargosPersonas','id','nombre'),array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <?php echo $form->emailField($modelResponsable,'email',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-5 col-xs-12">
                            <div class="form-group">
                                <label>Celular</label>
                                <?php echo $form->telField($modelResponsable,'celular',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-5 col-xs-7">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <?php echo $form->telField($modelResponsable,'telefono',array('class'=>'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-5">
                            <div class="form-group">
                                <label>Extención</label>
                                <?php echo $form->telField($modelResponsable,'telefono_ext',array('class'=>'form-control')); ?>
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