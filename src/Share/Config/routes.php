<?php
return [
	'pages' => array(
		['(<:empty>|index.html)', 'any', 'controller=HomeController;method=index'],
		

		'chanels' => [
			// Index of chanel
			['(<:empty>|index.html)', 'any', 'controller=ChanelsController;method=index'],

			['<:integer>/live.html', 'any', 'controller=ChanelsController;method=live;id={1}', 'as' => 'live'],
		],

		'me' => [
			['chanels.html', 'any', 'controller=MeController;method=myChanels'],
			['chanels/create.html', 'any', 'controller=MeController;method=create'],

			// Create chanel
			[
				'chanels/<:integer>/update.html',
				'any',
				'controller=MeController;method=update;id={1}',
				'as' => 'chanels_update'
			],

			['chanels/<:integer>/live.html', 'any', 'controller=MeController;method=live;id={1}',
				'as' => 'chanels_live'],
		],

		['login.html', 'any', 'controller=MeController;method=login'],
            
                'ajax' => [
                    'chanels' => [
                        ['videos.html', 'post', 'controller=ChanelsController;method=ajaxVideos', 'as' => 'videos']
                    ]
                ]
	)
];