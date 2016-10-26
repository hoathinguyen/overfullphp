<?php
return [
	//'View' => \lib\grass\app\view\View::class
	'func' => [
		'View' 	=> src\view\GrassView::class,
	],

	'otp' => [
		'URL'	=> lib\framework\grass\utility\URL::class,
		'Flash' => lib\framework\grass\marking\flash\Flash::class,
		'Auth'  => src\view\helper\AuthHelper::class
	]
];