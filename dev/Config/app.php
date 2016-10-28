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
	'sub-folder' => [
		'sharing' => [
			'root' => 'dev\Account',
			'namespace' => 'Dev\Account'
		],

		'_default' => [
			'root' => 'dev\Account',
			'namespace' => 'Dev\Account'
		]
	],

	'sub-domain' => [
		'sharing' => [
			'root' => 'dev\Home',
			'namespace' => 'Dev\Home'
		],

		'_default' => [
			'root' => 'dev\Home',
			'namespace' => 'Dev\Home'
		]
	]
];