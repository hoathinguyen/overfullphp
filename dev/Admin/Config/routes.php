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
		['login', 'any', 'controller=ProfileController;method=login'],
		['register', 'any', 'controller=ProfileController;method=register'],
		['logout', 'any', 'controller=ProfileController;method=logout'],
		['profile', 'any', 'controller=ProfileController;method=profile'],

		// Set url for docs
		'docs' => [
			['<:empty>', 'any', 'controller=DocsController;method=index'],
			['create', 'any', 'controller=DocsController;method=create'],
			['edit', 'any', 'controller=DocsController;method=edit'],
			['delete', 'any', 'controller=DocsController;method=delete']
		]
	)
);