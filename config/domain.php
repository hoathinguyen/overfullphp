<?php
/* ----------------------------------------------------
* app.php config file
* This file contains basic config, which need to have before
* call some logic,
* - config the project folder for sub-domain and sub-folder
* If your doamin is domain.com point the public folder on server
* and also your sub.domain.com point also to this folder on server
* but you would like to have another app for 2 domain.
*
* ----------------------------------------------------
*/
domain()
// -----------------------------------------------------------------------------
// Setting for cobonla id
// -----------------------------------------------------------------------------
->add(['localhost'], [
	'root' => 'resources',
	'namespace' => 'App',
	'alias' => 'app'
])
->setDefault(function($domain){});