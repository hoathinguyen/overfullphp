<?php
return [
	// Set alway build the view disp for developer
	'alway-build-otp' => false,

	'pattern' => \Overfull\Patterns\MVC\PatternHandler::class,

	'otp' => [
		'ext' => 'php',
		'helpers' => [
			'URL' => \Overfull\Utility\URLUtil::class
		]
	]
];