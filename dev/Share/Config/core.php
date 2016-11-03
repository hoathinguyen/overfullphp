<?php
return [
	// Set alway build the view disp for developer
	'alway-build-otp' => true,

	'pattern' => \Overfull\Pattern\MVC\PatternHandler::class,

	'otp' => [
		'ext' => 'php',
		'helpers' => [
			'URL' => \Overfull\Utility\URLUtil::class
		]
	],
	/**
	 * Salt string, this varible will be use in hash object class
	 */
	'salt' => 'overfull-overfull-overfull-overfull'
];