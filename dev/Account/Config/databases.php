<?php
return [
	'use' => 'default',

	'connections' => [

		'default' => [
			'user' => 'root',
			'password' => '',
			'port' => '',
			'host' => 'localhost',
			'type' => 'mysql', //pgsql
			'dbname' => 'viewer',
			'encoding' => 'utf8'
		],

		'test' => [
			'user' => 'root',
			'password' => '',
			'port' => '',
			'host' => 'localhost',
			'type' => 'mysql', //pgsql
			'dbname' => 'viewers',
			'encoding' => 'utf8'
		]
		
	]
];