<!-- Page Heading Start -->
<div class="page-heading">
	<h1><i class='fa fa-users'></i> Clientes</h1>
	<h3>Agregar un nuevo cliente al sistema</h3>
</div>
<!-- Page Heading End-->

<?php $this->renderPartial('_form', array(
										'model'=>$model,
										'modelPersona'=>$modelPersona,
										'modelPassword'=>$modelPassword
									)); ?>