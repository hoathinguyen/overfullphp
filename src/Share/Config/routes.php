<?php
return [
	'pages' => array(
		['(<:empty>|index.html)', 'any', 'controller=HomeController;method=index'],
		

		'chanels' => [
			// Index of chanel
			['(<:empty>|index.html)', 'any', 'controller=ChanelsController;method=index'],

			['<:integer>/live.html', 'any', 'controller=ChanelsController;method=live;id={1}'],
		],

		'me' => [
			['chanels.html', 'any', 'controller=MeController;method=myChanels'],

			// Create chanel
			['chanels/create.html', 'any', 'controller=MeController;method=create'],
			['chanels/<:integer>/update.html', 'any', 'controller=MeController;method=update;id={1}'],
			['chanels/<:integer>/live.html', 'any', 'controller=MeController;method=live;id={1}'],
		],

		['login.html', 'any', 'controller=MeController;method=login']
	)
];