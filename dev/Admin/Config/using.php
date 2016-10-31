<?php
return [
	'packages' => [
		'auth' => [
			'class' => \Packages\Authentication\Auth::class,
			'entity' => \Dev\Admin\Models\User::class,
			'id' => ['username'],
			'password' => 'password',
			'session' => 'auth'
		]
	],

	'weights' => []
];