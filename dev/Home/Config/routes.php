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

		['install.html', 'get', 'controller=DocsController;method=install;version={1}'],

		// Set URL for profile
		'docs' => [
			'<:integer>.[x|X]' => [
				['index.html', 'get', 'controller=DocsController;method=index;version={1}'],
				['posts-<:all>.html', 'get', 'controller=DocsController;method=posts;version={1}']
			]
		],

		//['install.html', 'get', 'controller=DocsController;method=install']
	)
);