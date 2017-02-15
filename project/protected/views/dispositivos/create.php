<!-- Page Heading Start -->
<div class="page-heading">
	<h1><i class='fa fa-gamepad'></i> Dispositivos</h1>
	<h3>Agregar un nuevo dispositivo al sistema</h3>
</div>
<!-- Page Heading End-->

<?php $this->renderPartial('_form', array(
										'model'=>$model,
									)); ?>