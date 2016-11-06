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
			['edit/<:integer>', 'any', 'controller=DocsController;method=edit'],
			['detail/<:integer>', 'any', 'controller=DocsController;method=detail'],
			['delete/<:integer>', 'any', 'controller=DocsController;method=delete']
		],

		// Set url for docs
		'files' => [
			['<:empty>', 'any', 'controller=FilesController;method=index'],
			['create', 'any', 'controller=FilesController;method=create'],
			['edit/<:integer>', 'any', 'controller=FilesController;method=edit'],
			['detail/<:integer>', 'any', 'controller=FilesController;method=detail'],
			['delete/<:integer>', 'any', 'controller=FilesController;method=delete']
		],

		// Set url for docs
		'services' => [
			['<:empty>', 'any', 'controller=ServicesController;method=index'],
			['create', 'any', 'controller=ServicesController;method=create'],
			['edit/<:integer>', 'any', 'controller=ServicesController;method=edit'],
			['detail/<:integer>', 'any', 'controller=ServicesController;method=detail'],
			['delete/<:integer>', 'any', 'controller=ServicesController;method=delete']
		],

		'ajax' => [
			'categories' => [
				['list.json', 'any', 'controller=CategoriesController;method=ajaxCategories']
			]
		]
	)
);