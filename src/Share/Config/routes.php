<?php
return [
	'pages' => array(
		['(<:empty>|index.html)', 'any', 'controller=HomeController;method=index'],
		['chanel/<:integer>/live.html', 'any', 'controller=ChanelsController;method=live;id={1}'],

		'chanel' => [
			// Index of chanel
			['(<:empty>|index.html)', 'any', 'controller=ChanelsController;method=index'],

			// Create chanel
			['create.html', 'any', 'controller=ChanelsController;method=create'],
		]
	)
];