<?php
return [
	'pages' => array(
		['(<:empty>|index.html)', 'any', 'controller=HomeController;action=index'],
		

		'chanels' => [
			// Index of chanel
			['(<:empty>|index.html)', 'any', 'controller=ChanelsController;action=index'],

			['<id:integer>/live.html', 'any', 'controller=ChanelsController;action=live;id={1}', 'as' => 'live'],
		],

		'me' => [
			['chanels.html', 'any', 'controller=MeController;action=myChanels'],
			['chanels/create.html', 'any', 'controller=MeController;action=create'],

			// Create chanel
			[
				'chanels/<:integer>/update.html',
				'any',
				'controller=MeController;action=update;id={1}',
				'as' => 'chanels_update'
			],

			['chanels/<:integer>/live.html', 'any', 'controller=MeController;action=live;id={1}',
				'as' => 'chanels_live'],
		],

		['login.html', 'any', 'controller=MeController;action=login'],
                ['logout.html', 'any', 'controller=MeController;action=logout'],
            
                'ajax' => [
                    'chanels' => [
                        ['videos.html', 'post', 'controller=ChanelsController;action=ajaxVideos', 'as' => 'videos'],
                        ['subscribe.html', 'post', 'controller=ChanelsController;action=ajaxSubscribe', 'as' => 'subscribe']
                    ]
                ]
	)
];