<?php
/* ----------------------------------------------------
* app.php config file
* This file contains basic config, which need to have before
* call some logic,
* - config the project folder for sub-domain and sub-folder
* If your doamin is domain.com point the public folder on server
* and also your sub.domain.com point also to this folder on server
* but you would like to have another app for 2 domain.
* So you can set project folder as following:
*
* 'sub-domain' => [
*  	'sub' => 'dev\subproject',
*  	'_default' => 'dev\default
* ]
*
* The same as sub domain you have 2 sub folder on url as:
* domain.com and domain.com/subfolder
* you also setting:
*
* 'sub-folder' => [
*  	'sub' => 'dev\subfolder',
*  	'_default' => 'dev\default
* ]
*
* ----------------------------------------------------
*/

return [
	'share.overfull.dev' => [
		'root' => 'dev/Share',
		'namespace' => 'Dev\Share'
	],

	'admin.overfull.dev' => 'root=dev/FirstAdmin;namespace=Dev\FirstAdmin',

	// 'admin.overfull.dev' => function(){
	// 	$page = \Bag::request()->get('uid');

	// 	if($page == 'framework'){
	// 		$page = [
	// 			'root' => 'dev/Admin',
	// 			'namespace' => 'Dev\Admin'
	// 		];

	// 		\Bag::session()->write('__page', $page);
	// 	} else{
	// 		$page = \Bag::session()->read('__page');
	// 	}

	// 	if(empty($page)){
	// 		$page = [
	// 			'root' => 'dev/FirstAdmin',
	// 			'namespace' => 'Dev\FirstAdmin'
	// 		];
	// 	}

	// 	return $page;
	// },

	'framework.admin.overfull.dev' => [
		'root' => 'dev/Admin',
		'namespace' => 'Dev\Admin'
	],

	'share.admin.overfull.dev' => [
		'root' => 'dev/ShareAdmin',
		'namespace' => 'Dev\ShareAdmin'
	],

	'[www.]overfull.dev' => [
		'root' => 'dev/Home',
		'namespace' => 'Dev\Home'
	],

	'[{sub}.]{domain}.{ext}' => [
		'root' => 'dev/Home',
		'namespace' => 'Dev\Home'
	],
];