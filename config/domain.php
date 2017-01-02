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
	/**
	 * Domain for Share app
	 */
	// Domain in localhost
	// 'share.overfull.dev' => [
	// 	'root' => 'src/Share',
	// 	'namespace' => 'Src\Share'
	// ],
	 [
		 'domain' => ['share.overfull.dev', 'share.overfull.net'],
		 'root' => 'src/Share',
 		 'namespace' => 'Src\Share'
	 ],

	/**
	 * Domain for Gift app
	 */
	[
		'domain' => ['gift.overfull.dev', 'gift.overfull.net'],
	    'root' => 'src/Gift',
		'namespace' => 'Src\Gift'
	],

	/**
	 * Domain for Shop app
	 */
	 [
		 'domain' => ['shop.overfull.dev', 'shop.overfull.net'],
		 'root' => 'src/Shop',
		 'namespace' => 'Src\Shop'
	 ],
	/**
	 * Domain for admin app
	 */
	'admin.overfull.dev' => 'root=src/FirstAdmin;namespace=Src\FirstAdmin',

	'framework.admin.overfull.dev' => [
		'root' => 'src/Admin',
		'namespace' => 'Src\Admin'
	],

	'share.admin.overfull.dev' => [
		'root' => 'src/ShareAdmin',
		'namespace' => 'Src\ShareAdmin'
	],

	'[www.]overfull.dev' => [
		'root' => 'src/Home',
		'namespace' => 'Src\Home'
	],

	'[{sub}.]{domain}.{ext}' => [
		'root' => 'src/Home',
		'namespace' => 'Src\Home'
	],
];
