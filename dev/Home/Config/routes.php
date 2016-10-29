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
			['<:empty>', 'get', 'controller=DocsController;method=index'],
			['index.html', 'get', 'controller=DocsController;method=index'],
			['detail.html', 'get', 'controller=DocsController;method=detail']
		],

		['install.html', 'get', 'controller=DocsController;method=install']
	)
);