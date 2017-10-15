<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuarios-form',
	'action'=>($model->isNewRecord)?$this->createUrl('clientes/create__ajax'):$this->createUrl('clientes/update__ajax/'.$model->id_cliente),
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>'form__ajax',
		'role'=>'form',
		'method'=>'post',
		'data-form__success'=>($model->isNewRecord)?'$.formClear($form)':'',
	),
)); ?>

	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header">
					<h2><strong>Datos</strong> generales de la empresa</h2>
					<div class="additional-btn">
						<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
					</div>
				</div>
				<div class="widget-content padding">
                    <div class="row">
                        <div class="col-sm-8 col-xs-12">
                            <div class="form-group">
                                <label>Razón Social de la Empresa</label>
                                <?php echo $form->textField($modelCliente,'razon_social',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>NIT</label>
                                <?php echo $form->numberField($modelCliente,'nit',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Departamento</label>
                                <?php
                                    $departamentos = Lugares::model()->findAllByAttributes(array(
                                        'lugar'=>1
                                    ), array(
                                        'order'=>'t.nombre ASC'
                                    ));
                                    $departamento = ($modelCliente->isNewRecord)?'':$modelCliente->ciudad0->lugar;
                                    echo CHtml::dropDownList(
                                        'Clientes[departamento]',
                                        $departamento,
                                        MyMethods::doListModels($departamentos,'id','nombre'),
                                        array(
                                            'class'=>'form-control',
                                            'required'=>true,
                                            'data-url-load'=>$this->createUrl('lugares/getCiudades')
                                        )
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Municipio</label>
                                <?php echo $form->dropDownList(
                                    $modelCliente,
                                    'municipio',
                                    MyMethods::doListModels([]),
                                    array(
                                        'class'=>'form-control',
                                        'required'=>true,
                                        'disabled'=>true,
                                        'data-url-load'=>$this->createUrl('lugares/getLocalidades')
                                    )
                                ); ?>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="form-group">
                                <label>Dirección</label>
                                <?php echo $form->textField($modelCliente,'direccion',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <?php echo $form->telField($modelCliente,'telefono',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Sector</label>
                                <?php echo $form->dropDownList($modelCliente,'sector',MyMethods::getListSelect('SectoresEconomicos','id','nombre'),array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Código DIAN Actividad Económica</label>
                                <?php echo $form->numberField($modelCliente,'codigo_actividad_economica',array('class'=>'form-control','min'=>0,'required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Descripción General</label>
                                <?php echo $form->textArea($modelCliente,'descripcion',array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>

        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Datos</strong> representante legal</h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Representante Lesgal o Apoderado</label>
                                <?php echo CHtml::textField('ClientesPersonas[0][nombre]',$modelRepresentanteLegal->nombre,array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Identificación</label>
                                <div class="row">
                                    <div class="col-sm-4" style="padding: 0 6px 0 15px">
                                        <?php echo CHtml::dropDownList('ClientesPersonas[0][tipo_identificacion]',$modelRepresentanteLegal->tipo_identificacion,MyMethods::getListSelect('TiposIdentificacion','id','sigla'),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                    <div class="col-sm-8" style="padding: 0 15px 0 6px">
                                        <?php echo CHtml::numberField('ClientesPersonas[0][identificacion]',$modelRepresentanteLegal->identificacion,array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Cargo</label>
                                <?php echo CHtml::dropDownList('ClientesPersonas[0][cargo]',$modelRepresentanteLegal->cargo,MyMethods::getListSelect('CargosPersonas','id','nombre'),array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <?php echo CHtml::emailField('ClientesPersonas[0][email]',$modelRepresentanteLegal->email,array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Celular</label>
                                <?php echo CHtml::telField('ClientesPersonas[0][celular]',$modelRepresentanteLegal->celular,array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-7">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <?php echo CHtml::telField('ClientesPersonas[0][telefono]',$modelRepresentanteLegal->telefono,array('class'=>'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-5">
                            <div class="form-group">
                                <label>Extención</label>
                                <?php echo CHtml::telField('ClientesPersonas[0][telefono_ext]',$modelRepresentanteLegal->telefono_ext,array('class'=>'form-control')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h2><strong>Datos</strong> responsable acompañamiento del programa PSG</h2>
                    <div class="additional-btn">
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                    </div>
                </div>
                <div class="widget-content padding">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Responsable Para el Acompañamiento del Programa PSG</label>
                                <?php echo CHtml::textField('ClientesPersonas[1][nombre]',$modelResponsablePrograma->nombre,array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Identificación</label>
                                <div class="row">
                                    <div class="col-sm-4" style="padding: 0 6px 0 15px">
                                        <?php echo CHtml::dropDownList('ClientesPersonas[1][tipo_identificacion]',$modelResponsablePrograma->tipo_identificacion,MyMethods::getListSelect('TiposIdentificacion','id','sigla'),array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                    <div class="col-sm-8" style="padding: 0 15px 0 6px">
                                        <?php echo CHtml::numberField('ClientesPersonas[1][identificacion]',$modelResponsablePrograma->identificacion,array('class'=>'form-control','required'=>true)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Cargo</label>
                                <?php echo CHtml::dropDownList('ClientesPersonas[1][cargo]',$modelResponsablePrograma->cargo,MyMethods::getListSelect('CargosPersonas','id','nombre'),array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <?php echo CHtml::emailField('ClientesPersonas[1][email]',$modelResponsablePrograma->email,array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Celular</label>
                                <?php echo CHtml::telField('ClientesPersonas[1][celular]',$modelResponsablePrograma->celular,array('class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-7">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <?php echo CHtml::telField('ClientesPersonas[1][telefono]',$modelResponsablePrograma->telefono,array('class'=>'form-control')); ?>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-5">
                            <div class="form-group">
                                <label>Extención</label>
                                <?php echo CHtml::telField('ClientesPersonas[1][telefono_ext]',$modelResponsablePrograma->telefono_ext,array('class'=>'form-control')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header">
					<h2><strong>Datos</strong> para el acceso</h2>
					<div class="additional-btn">
						<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
					</div>
				</div>
				<div class="widget-content padding">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Correo electrónico</label>
								<?php echo $form->textField($model,'email',array('class'=>'form-control','required'=>true)); ?>
						  	</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Contraseña</label>
								<?php echo $form->textField($modelPassword,'password',array('maxlength'=>45,'class'=>'form-control','required'=>true)); ?>
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
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Guardar', array('class'=>'btn-set-redirect btn btn-success', 'data-redirect'=>'')); ?>
				<?php echo ($model->isNewRecord)?CHtml::submitButton('Agregar y Crear Estación', array('class'=>'btn-set-redirect btn btn-primary', 'data-redirect'=>$this->createUrl('estaciones/create').'?client=')):''; ?>
                <a href="<?php echo $this->createUrl('clientes/admin'); ?>" class="btn btn-danger">Cancelar</a>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>