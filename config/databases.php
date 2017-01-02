<?php
return [
	'use' => 'server',

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
		],

    	'server' => [
			'user' => 'inamlim9_overful',
			'password' => 'Tltttml14112109',
			'port' => '80',
			'host' => '103.18.6.177',
			'type' => 'mysql', //pgsql
			'dbname' => 'inamlim9_overfull',
			'encoding' => 'utf8'
		],

        'server_share' => [
			'user' => 'inamlim9_share',
			'password' => 'Tltttml14112109',
			'port' => '80',
			'host' => '103.18.6.177',
			'type' => 'mysql', //pgsql
			'dbname' => 'inamlim9_share',
			'encoding' => 'utf8'
		],

		// Database for shop
		'overfullShop' => [
			'user' => 'root',
			'password' => '',
			'port' => '80',
			'host' => 'localhost',
			'type' => 'mysql', //pgsql
			'dbname' => 'overfullShop',
			'encoding' => 'utf8'
		]
	]
];
