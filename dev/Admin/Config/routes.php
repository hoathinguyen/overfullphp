<?php
return array(
	'base' => 0,
	
	'pages' => array(
		['<:empty>', 'any', array(
			'controller' 	=> 'HomeController',
			'method' 		=> 'index',
			'filter' 		=> [],
			//'view'			=> 
		)],

		// Set URL for profile
		['login.html', 'any', 'controller=ProfileController;method=login'],
		['register.html', 'any', 'controller=ProfileController;method=register']
	)
);