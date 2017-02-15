<div class="full-content-center">
	<p class="text-center"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="Logo"></a></p>
	<div class="login-wrap animated flipInX">
		<div class="login-block">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/users/default.png" class="img-circle not-logged-avatar">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>false,
				'clientOptions'=>array(
					'validateOnSubmit'=>false,
				),
				'htmlOptions'=>array(
					'role'=>"form",
					'method'=>"POST",
					'class'=>'form__ajax',
					'data-form__success'=>'$.reload()'
				)
			)); ?>
				<div class="form-group login-input">
					<i class="fa fa-user overlay"></i>
					<?php echo $form->emailField($model,'username', array("class"=>'form-control text-input', "placeholder"=>'Usuario', "required"=>true)); ?>
				</div>
				<div class="form-group login-input">
					<i class="fa fa-key overlay"></i>
					<?php echo $form->passwordField($model,'password', array("class"=>'form-control text-input', "placeholder"=>'*******', "required"=>true)); ?>
				</div>

				<div class="form-group login-input">
					<div class="checkbox">
						<label>
							<?php echo $form->checkBox($model,'rememberMe', array('class'=>'form-control')); ?> Recordar mis datos</strong>
						</label>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<button type="submit" class="btn btn-success btn-block">LOGIN</button>
					</div>
				</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>
	
</div>