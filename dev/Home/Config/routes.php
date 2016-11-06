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

		['services.html', 'get', 'controller=HomeController;method=services'],

		['install.html', 'get', 'controller=DocsController;method=install;version={1}'],

		// Set URL for profile
		'packages' => [
			'<:integer>.[x|X]' => [
				['index.html', 'get', 'controller=DocsController;method=packages;version={1}'],
			]
		],

		// Set URL for profile
		'weights' => [
			'<:integer>.[x|X]' => [
				['index.html', 'get', 'controller=DocsController;method=weights;version={1}'],
			]
		],

		// Set URL for profile
		'patterns' => [
			'<:integer>.[x|X]' => [
				['index.html', 'get', 'controller=DocsController;method=patterns;version={1}'],
			]
		],
		// Set URL for profile
		'docs' => [
			'<:integer>.[x|X]' => [
				['index.html', 'get', 'controller=DocsController;method=index;version={1}'],
				['posts-<:all>.html', 'get', 'controller=DocsController;method=posts;version={1}']
			]
		],

		// Set URL for profile
		'download' => [
			['<:integer>/weight.html', 'get', 'controller=FilesController;method=download;id={1}'],
			['<:integer>/package.html', 'get', 'controller=FilesController;method=download;id={1}'],
			['<:integer>/framework.html', 'get', 'controller=FilesController;method=download;id={1}'],
			['<:integer>/pattern.html', 'get', 'controller=FilesController;method=download;id={1}']
		],

		//['install.html', 'get', 'controller=DocsController;method=install']
	)
);