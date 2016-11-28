<?php
return [
    'pages' => array(
        ['<:empty>', 'any', 'controller=HomeController;action=index', 'as' => 'home_empty'],
        ['index.html', 'any', 'controller=HomeController;action=index', 'as' => 'home'],

        'chanels' => [
            // Index of chanel
            ['(<:empty>|index.html)', 'any', 'controller=ChanelsController;action=index'],

            ['<id:integer>/live.html', 'any', 'controller=ChanelsController;action=live;id={1}', 'as' => 'live'],
            
            ['<id:integer>/videos.html', 'any', 'controller=ChanelsController;action=videos;id={1}', 'as' => 'videos'],
            
            ['<id:integer>/info.html', 'any', 'controller=ChanelsController;action=info;id={1}', 'as' => 'info'],
        ],
        
        'videos' => [
            ['<id:integer>/view.html', 'any', 'controller=VideosController;action=view;id={1}', 'as' => 'view'],
        ],

        'me' => [
            ['chanels.html', 'any', 'controller=MeController;action=myChanels','as' => 'chanels'],
            ['chanels/create.html', 'any', 'controller=MeController;action=create'],

            // Create chanel
            [
                'chanels/<:integer>/update.html',
                'any',
                'controller=MeController;action=update;id={1}',
                'as' => 'chanels_update'
            ],

            ['chanels/<id:integer>/live.html', 'any', 'controller=MeController;action=live;id={1}',
                        'as' => 'live'],
            
            ['chanels/<id:integer>/updatelive.html', 'any', 'controller=MeController;action=updateLive;id={1}',
                        'as' => 'updatelive'],
            
            ['chanels/<id:integer>/endlive.html', 'any', 'controller=MeController;action=endLive;id={1}',
                        'as' => 'endlive'],
        ],

        ['login.html', 'any', 'controller=MeController;action=login', 'as' => 'login'],
        ['logout.html', 'any', 'controller=MeController;action=logout', 'as' => 'logout'],
        ['register.html', 'any', 'controller=MeController;action=register', 'as' => 'register'],
        ['forget.html', 'any', 'controller=MeController;action=forget', 'as' => 'forget'],
        
        'ajax' => [
            'chanels' => [
                ['videos.html', 'post', 'controller=ChanelsController;action=ajaxVideos', 'as' => 'videos'],
                ['subscribe.html', 'post', 'controller=ChanelsController;action=ajaxSubscribe', 'as' => 'subscribe']
            ]
        ]
    )
];