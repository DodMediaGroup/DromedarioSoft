<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="description" content="">
    <meta name="keywords" content="CRM">
    <meta name="author" content="DOD Media Group">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- Base Css Files -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/fontello/css/fontello.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/animate-css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/nifty-modal/css/component.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/magnific-popup/magnific-popup.css" rel="stylesheet" /> 
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/ios7-switch/ios7-switch.css" rel="stylesheet" /> 
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/pace/pace.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/sortable/sortable-theme-bootstrap.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-icheck/skins/all.css" rel="stylesheet" />
    <!-- Code Highlighter for Demo -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/prettify/github.css" rel="stylesheet" />
    
	    <!-- Extra CSS Libraries Start -->
	    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-notifyjs/styles/metro/notify-metro.css" rel="stylesheet" type="text/css" />
	    <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/rickshaw/rickshaw.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/morrischart/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-jvectormap/css/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-clock/clock.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-calendar/css/bic_calendar.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/sortable/sortable-theme-bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-weather/simpleweather.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-xeditable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-datatables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-datatables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet" type="text/css" />

	    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
</head>
<body class="fixed-left">
	<div id="wrapper">

		<?php $this->renderPartial('//layouts/__bar-top'); ?>

		<?php $this->renderPartial('//layouts/__sidebar__left'); ?>

		<?php $this->renderPartial('//layouts/__sidebar__right'); ?>

		<!-- Start right content -->
		<div class="content-page">
			<div class="content">
				<?php echo $content; ?>
				<footer>
	                DOD Media Group &copy; 2016
	                <div class="footer-links pull-right">
	                	<a href="#">Help</a>
	                	<a href="#">Contact Us</a>
	                </div>
	            </footer>
			</div>
		</div>
		<!-- End right content -->

	</div>
	
		
	<!-- Modal Logout -->
	<div class="md-modal md-just-me" id="logout-modal">
		<div class="md-content">
			<h3><strong>Logout</strong> Confirmation</h3>
			<div>
				<p class="text-center">¿Seguro que desea cerrar su sesión de Dromedario?</p>
				<p class="text-center">
					<button class="btn btn-danger md-close">No!</button>
					<a href="<?php echo Yii::app()->createUrl('site/logout/') ?>" class="btn btn-success md-close">Si, Estoy seguro</a>
				</p>
			</div>
		</div>
	</div>
	<!-- Modal End -->

	<!-- the overlay modal element -->
	<div class="md-overlay"></div>
	<!-- End of eoverlay modal -->

	<!-- MODAL LOADING -->
	<div class="modal__loading"></div>

	<!-- PRINT CONTENT -->
	<div class="print__content__page">
		
	</div>
	
	<script>
		var resizefunc = [];
	</script>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery/jquery-1.11.1.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jqueryui/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-ui-touch/jquery.ui.touch-punch.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-detectmobile/detect.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-animate-numbers/jquery.animateNumbers.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/ios7-switch/ios7.switch.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/fastclick/fastclick.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-blockui/jquery.blockUI.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-bootbox/bootbox.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-sparkline/jquery-sparkline.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/nifty-modal/js/classie.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/nifty-modal/js/modalEffects.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/sortable/sortable.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-fileinput/bootstrap.file-input.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-select2/select2.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/magnific-popup/jquery.magnific-popup.min.js"></script> 
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/pace/pace.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-icheck/icheck.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/doT/doT.min.js"></script>

	<!-- Charts Libraries -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
	<script src="https://code.highcharts.com/stock/highstock.js"></script>
	<!-- <script src="https://code.highcharts.com/maps/highmaps.js"></script> -->

	<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/maps/modules/map.js"></script>
	<script src="https://code.highcharts.com/maps/modules/data.js"></script>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/raphael/raphael-min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/morrischart/morris.min.js"></script>

	<!-- Demo Specific JS Libraries -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/prettify/prettify.js"></script>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/numberstoletters/numberstoletters.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/init.js"></script>

	<!-- Page Specific JS Libraries -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-notifyjs/notify.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-notifyjs/styles/metro/notify-metro.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-xeditable/js/bootstrap-editable.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-datatables/js/dataTables.bootstrap.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery-datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-inputmask/inputmask.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/shortcut/shortcut.js"></script>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/bootstrap-calendar/js/bic_calendar.min.js"></script>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/components/highchart.js"></script>
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/template.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
</body>
</html>