<?php
return [
	'use' => 'overfull',

	'connections' => [

		'overfull' => [
			'user' => 'root',
			'password' => '',
			'port' => '',
			'host' => 'localhost',
			'type' => 'mysql', //pgsql
			'dbname' => 'overfull',
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