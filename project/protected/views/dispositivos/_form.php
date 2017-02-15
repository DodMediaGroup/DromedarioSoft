<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dispositivos-form',
	'action'=>($model->isNewRecord)?$this->createUrl('dispositivos/create__ajax'):$this->createUrl('dispositivos/update__ajax/'.$model->id_cliente),
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
					<h2><strong>Información</strong> dispositivo</h2>
					<div class="additional-btn">
						<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
					</div>
				</div>
				<div class="widget-content padding">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Identificación Cliente *</label>
								<?php echo $form->hiddenField($model, 'usuario', array('required'=>true)); ?>
								<input type="text" class="input__autocomplete form-control" required data-autocomplete__data="<?php echo $this->createUrl('clientes/autocomplete__json'); ?>" data-autocomplete__input="#Dispositivos_usuario">
						  	</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Nombre *</label>
								<?php echo $form->textField($model,'nombre',array('maxlength'=>155,'class'=>'form-control','required'=>true)); ?>
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
                <a href="<?php echo $this->createUrl('dispositivos/admin'); ?>" class="btn btn-danger">Cancelar</a>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>