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
			['(.*).html', 'get', 'controller=DocsController;method=detail']
		]
	)
);