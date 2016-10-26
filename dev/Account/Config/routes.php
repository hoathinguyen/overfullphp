<?php
return array(
	'base' => 0,
	
	'pages' => array(
		['<:empty>', 'any', array(
			'controller' 	=> 'HomeController',
			'method' 		=> 'index',
			'filter' 		=> [],
			//'view'			=> 
		)]
		// ['<:empty>', 'any', [
		// 		'controller' => 'TestController',
		// 		'method'	 => 'setting',
		// 		'filter'	=> [
		// 			'class' => 'AdminFilter',
		// 			'parameters' => 'test'
		// 		],

		// 		//'view' => 'View',

		// 		'request' => [

		// 		],

		// 		'response' => [
		// 			'format' => \Overfull\Http\Response\ResponseFormat::HTML
		// 		]
		// 	]
		// ],

		// //--------------------------------------
		// //
		// // Route for resource in admin page
		// //
		// //
		// //
		// //--------------------------------------
		// ['array-<:all>.html', 'any', [
		// 		'controller' => 'admin\\SettingsController{1}',
		// 		'method'	 => 'setting',
		// 		'filter'	=> [
		// 			'class' => 'AdminFilter'
		// 		]
		// 	]
		// ],

		// ['<:alphanumeric>/<:integer>.html', 'get', function($url, $parameters){
		// 	//print_r($parameters);
		// 	return [
		// 		'controller' => '{1}',
		// 		'parameters' => '1'
		// 		// 'method'	 => 'deleteContact',
		// 		// 'filter'	=> [
		// 		// 	'class' => 'AdminFilter'
		// 		// ]
		// 	];
		// }],

		// //--------------------------------------
		// //
		// // Route for login in admin page
		// //
		// //
		// //
		// //--------------------------------------
		// ['vn/test.html?name=<:all>', 'any', 'controller=admin{1};method=index'],

		// // Config route with prefix
		// 'vn' => [
		// 	['string.html?name=<:all>', 'any', 'controller=admin{1};method=index'],
		// 	['detail/<:integer>', 'any', 'controller=admin{1};method=index']
		// ]
	)
);