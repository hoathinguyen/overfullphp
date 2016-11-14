<?php
return [
	'use' => 'share',

	'connections' => [

		'overfull' => [
			'user' => 'root',
			'password' => '',
			'port' => '80',
			'host' => 'localhost',
			'type' => 'mysql', //pgsql
			'dbname' => 'overfull',
			'encoding' => 'utf8'
		],

		'share' => [
			'user' => 'root',
			'password' => '',
			'port' => '80',
			'host' => 'localhost',
			'type' => 'mysql', //pgsql
			'dbname' => 'share',
			'encoding' => 'utf8'
		]
	]
];