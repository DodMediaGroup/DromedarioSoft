<?php
	$path = explode("/",Yii::app()->request->pathInfo);
?>


<?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
	<li class='has_sub'>
		<a href='#' class="<?php echo (strtolower($path[0]) == 'clientes')?'active':''; ?>">
			<i class='fa fa-users'></i>
			<span>Clientes</span>
			<span class="pull-right">
				<i class="fa fa-angle-down"></i>
			</span>
		</a>
		<ul>
			<li>
				<a href='<?php echo $this->createUrl('clientes/admin') ?>' class="<?php echo (count($path) > 1)?((strtolower($path[0]) == 'clientes' && strtolower($path[1]) == 'admin')?'active':''):''; ?>">
					<span>Lista</span>
				</a>
			</li>
			<li>
				<a href='<?php echo $this->createUrl('clientes/create') ?>' class="<?php echo (count($path) > 1)?((strtolower($path[0]) == 'clientes' && strtolower($path[1]) == 'create')?'active':''):''; ?>">
					<span>Agregar</span>
				</a>
			</li>
		</ul>
	</li>
<?php } ?>

<li class='has_sub'>
	<a href='#' class="<?php echo (strtolower($path[0]) == 'dispositivos')?'active':''; ?>">
		<i class='fa fa-gamepad'></i>
		<span>Dispositivos</span>
		<span class="pull-right">
			<i class="fa fa-angle-down"></i>
		</span>
	</a>
	<ul>
		<li>
			<a href='<?php echo $this->createUrl('dispositivos/admin') ?>' class="<?php echo (count($path) > 1)?((strtolower($path[0]) == 'dispositivos' && strtolower($path[1]) == 'admin')?'active':''):''; ?>">
				<span>Lista</span>
			</a>
		</li>
		<?php if(Yii::app()->user->getState('_userRol') == 1){ ?>
			<li>
				<a href='<?php echo $this->createUrl('dispositivos/create') ?>' class="<?php echo (count($path) > 1)?((strtolower($path[0]) == 'dispositivos' && strtolower($path[1]) == 'create')?'active':''):''; ?>">
					<span>Agregar</span>
				</a>
			</li>
		<?php } ?>
	</ul>
</li>