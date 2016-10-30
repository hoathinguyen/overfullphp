<?php
return array(
	'base' => 0,
	
	'pages' => array(
		['<:empty>', 'any', array(
			'controller' 	=> 'DocsController',
			'method' 		=> 'index',
			'filter' 		=> [],
			//'view'			=> 
		)],

		// Set URL for profile
		'docs' => [
			'<:integer>.[x|X]' => [
				['index.html', 'get', 'controller=DocsController;method=index;version={1}'],
				['posts-<:all>.html', 'get', 'controller=DocsController;method=index;version={1}']
			]
		],

		//['install.html', 'get', 'controller=DocsController;method=install']
	)
);