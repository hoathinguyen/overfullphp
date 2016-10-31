<?php
return [
	'packages' => [
		'auth' => [
			'class' => \Packages\Authentication\Auth::class,
			'table' => 'users',
			'id' => ['username'],
			'password' => 'password' 
		]
	],

	'weights' => []
];