<?php
return [
	'auth' => [
		'class' => \Packages\Authentication\Auth::class,
		'entity' => \Dev\Admin\Models\User::class,
		'id' => ['username'],
		'secret' => 'password',
		'session' => 'auth',
		'hasher' => \Overfull\Security\Hasher\SimpleHasher::class
	]
];