<!-- Page Heading Start -->
<div class="page-heading">
	<h1><i class='fa fa-users'></i> Clientes</h1>
	<h3>Listado de clientes</h3>
</div>
<!-- Page Heading End-->

<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-header">
				<h2><strong>Lista</strong> proveedores</h2>
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
                                <th>Razon Social</th>
                                <th>NIT</th>
                                <th>Ciudad</th>
                                <th>Teléfono</th>
                                <th>Representante Legal</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
                                <th>No.</th>
                                <th>Razon Social</th>
                                <th>NIT</th>
                                <th>Ciudad</th>
                                <th>Teléfono</th>
                                <th>Representante Legal</th>
                                <th>Opciones</th>
							</tr>
						</tfoot>
						<tbody>
							<?php foreach ($clientes as $key => $cliente) {
								$itemID = 'cliente_tr_'.$key;
							?>
								<tr id="<?php echo $itemID; ?>">
									<td><?php echo $key+1; ?></td>
									<td><?php echo $cliente->razon_social; ?></td>
									<td><?php echo $cliente->nit; ?></td>
									<td><?php echo $cliente->municipio0->nombre; ?></td>
									<td><?php echo $cliente->telefono; ?></td>
									<td><?php echo $cliente->representanteLegal->nombre; ?></td>
									<td>
										<div class="btn-group btn-group-xs">
											<a href="<?php echo $this->createUrl('clientes/estaciones/'.$cliente->id) ?>" data-toggle="tooltip" title="Estaciones" class="btn btn-default"><i class="fa fa-building-o"></i></a>
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