<?php
	if(isset($cliente)){
		$persona = $cliente->personases[0];
	}
?>

<!-- Page Heading Start -->
<?php if(isset($cliente)){ ?>
	<div class="page-heading">
		<h1><i class='fa fa-users'></i> Clientes <small>- <?php echo $persona->nombre ?> <?php echo $persona->apellido ?> [<?php echo $persona->identificacion ?>]</small></h1>
		<h3>Listado de dispositivos</h3>
	</div>
<?php }
else{ ?>
	<div class="page-heading">
		<h1><i class='fa fa-gamepad'></i> Dispositivos</h1>
		<h3>Listado de dispositivos</h3>
	</div>
<?php } ?>
<!-- Page Heading End-->

<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-header">
				<h2><strong>Lista</strong> dispositivos</h2>
				<div class="additional-btn">
					<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
				</div>
			</div>
			<div class="widget-content padding">
				<div class="table-responsive">
					<table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No.</th>
								<?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
									<th>Cliente</th>
									<th>Llave</th>
								<?php } ?>
								<th>Nombre</th>
								<th>Fecha Instalación</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>No.</th>
								<?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
									<th>Cliente</th>
									<th>Llave</th>
								<?php } ?>
								<th>Nombre</th>
                                <th>Fecha Instalación</th>
								<th>Opciones</th>
							</tr>
						</tfoot>
						<tbody>
							<?php foreach ($dispositivos as $key => $dispositivo) {
								$itemID = 'dispositivo_tr_'.$key;
								$cliente = $dispositivo->site0->cliente0;
							?>
								<tr id="<?php echo $itemID; ?>">
									<td><?php echo $key+1; ?></td>
									<?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
										<td>[<?php echo $cliente->nit; ?>] <?php echo $cliente->razon_social; ?></td>
										<td><?php echo $dispositivo->llave; ?></td>
									<?php } ?>
									<td><?php echo $dispositivo->nombre; ?></td>
									<td><?php echo $dispositivo->fecha_instalacion; ?></td>
									<td>
										<div class="btn-group btn-group-xs">
											<a href="<?php echo $this->createUrl('dispositivos/'.$dispositivo->id) ?>" data-toggle="tooltip" title="Ver" class="btn btn-default"><i class="fa fa-search-plus"></i></a>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>