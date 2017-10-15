<!-- Page Heading Start -->
<div class="page-heading">
    <h1><i class='fa fa-building-o'></i> <?php echo $site->cliente0->razon_social; ?> - <?php echo $site->nombre; ?></h1>
    <h3>CENSO DE CARGA</h3>
</div>
<!-- Page Heading End-->

<?php $this->renderPartial('censo/_form', array(
    'site'=>$site,

    'model'=>$model,

    'energeticos'=>$energeticos
)); ?>