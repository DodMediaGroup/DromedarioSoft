<!-- Page Heading Start -->
<?php if(isset($cliente)){ ?>
    <div class="page-heading">
        <h1><i class='fa fa-users'></i> Estaciones <small>- <?php echo $cliente->razon_social ?> [<?php echo $cliente->nit ?>]</small></h1>
        <h3>Listado de estaciones</h3>
    </div>
<?php }
else{ ?>
    <div class="page-heading">
        <h1><i class='fa fa-building-o'></i> Estaciones</h1>
        <h3>Listado de estaciones</h3>
    </div>
<?php } ?>
<!-- Page Heading End-->

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <h2><strong>Lista</strong> estaciones</h2>
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
                            <?php } ?>
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No.</th>
                            <?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
                                <th>Cliente</th>
                            <?php } ?>
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($estaciones as $key => $estacion) {
                                $itemID = 'estacion_tr_'.$key;
                                $cliente = $estacion->cliente0;
                            ?>
                            <tr id="<?php echo $itemID; ?>">
                                <td><?php echo $key+1; ?></td>
                                <?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
                                    <td>
                                        [<?php echo $cliente->nit; ?>] <?php echo $cliente->razon_social; ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <?php echo $estacion->nombre; ?>
                                    <?php if(!$estacion->registroCompleto()){ ?>
                                        <span class="label label-danger">Registro por completar</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <?php if(!$estacion->registroCompleto()){ ?>
                                            <a href="<?php echo $this->createUrl('estaciones/create_operacion_sitio?site='.$estacion->id) ?>" data-toggle="tooltip" title="Completar registro" class="btn btn-default"><i class="fa fa-code-fork"></i></a>
                                        <?php } ?>
                                        <a href="<?php echo $this->createUrl('estaciones/'.$estacion->id) ?>" data-toggle="tooltip" title="Dispositivos" class="btn btn-default"><i class="fa fa-bolt"></i></a>
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