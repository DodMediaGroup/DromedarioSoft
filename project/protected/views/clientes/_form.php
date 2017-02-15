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
					<h2><strong>Información</strong> personal</h2>
					<div class="additional-btn">
						<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
					</div>
				</div>
				<div class="widget-content padding">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Documento Identificación *</label>
								<?php echo $form->textField($modelPersona,'identificacion',array('class'=>'form-control','required'=>true)); ?>
						  	</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Nombre(s) *</label>
								<?php echo $form->textField($modelPersona,'nombre',array('maxlength'=>155,'class'=>'form-control','required'=>true)); ?>
						  	</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Apellido(s) *</label>
								<?php echo $form->textField($modelPersona,'apellido',array('maxlength'=>155,'class'=>'form-control','required'=>true)); ?>
						  	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="widget">
				<div class="widget-header">
					<h2><strong>Datos</strong> acceso</h2>
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
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Guardar', array('class'=>'btn btn-success')); ?>
                <a href="<?php echo $this->createUrl('clientes/admin'); ?>" class="btn btn-danger">Cancelar</a>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>