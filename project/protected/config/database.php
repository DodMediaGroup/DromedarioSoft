<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost;dbname=dod_dromedario_hardware',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',

	/*'connectionString' => 'mysql:host=localhost;dbname=dodmedia_bd_dromedario_hardware',
	'emulatePrepare' => true,
	'username' => 'dodmedia_sergio',
	'password' => ')$f)@J&Iv[I&',
	'charset' => 'utf8',*/
	
);