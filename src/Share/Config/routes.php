<?php
return [
	'pages' => array(
		['(<:empty>|index.html)', 'any', 'controller=HomeController;method=index'],
		

		'chanels' => [
			// Index of chanel
			['(<:empty>|index.html)', 'any', 'controller=ChanelsController;method=index'],

			// Create chanel
			['create.html', 'any', 'controller=ChanelsController;method=create'],

			['<:integer>/live.html', 'any', 'controller=ChanelsController;method=live;id={1}'],
		],

		'me' => [
			['chanels.html', 'any', 'controller=MeController;method=myChanels']
		],

		['login.html', 'any', 'controller=MeController;method=login']
	)
];