<?php
return [
    'pages' => array(
//        'me' => [
//            ['chanels.html', 'any', 'controller=MeController;action=myChanels','as' => 'chanels'],
//            ['chanels/create.html', 'any', 'controller=MeController;action=create'],
//
//            // Create chanel
//            [
//                'chanels/<:integer>/update.html',
//                'any',
//                'controller=MeController;action=update;id={1}',
//                'as' => 'chanels_update'
//            ],
//
//            ['chanels/<id:integer>/live.html', 'any', 'controller=MeController;action=live;id={1}',
//                        'as' => 'live'],
//            
//            ['chanels/<id:integer>/updatelive.html', 'any', 'controller=MeController;action=updateLive;id={1}',
//                        'as' => 'updatelive'],
//            
//            ['chanels/<id:integer>/endlive.html', 'any', 'controller=MeController;action=endLive;id={1}',
//                        'as' => 'endlive']
//        ],
        
        /**
         * Route for page
         */
        array('format' => 'index.html', 'method' => 'any', 'parameters' => 'controller=Site\HomeController;action=index', 'as' => 'home'),
        array('format' => '<:empty>', 'method' => 'any', 'parameters' => 'controller=Site\HomeController;action=index', 'as' => 'home_empty'),
        array('format' => 'login.html', 'method' => 'any', 'parameters' => 'controller=Site\AccountController;action=login', 'as' => 'login'),
        array('format' => 'logout.html', 'method' => 'any', 'parameters' => 'controller=Site\AccountController;action=logout', 'as' => 'logout'),
        array('format' => 'register.html', 'method' => 'any', 'parameters' => 'controller=Site\AccountController;action=register', 'as' => 'register'),
        array('format' => 'forget.html', 'method' => 'any', 'parameters' => 'controller=Site\AccountController;action=forget', 'as' => 'forget'),
        
        /**
         * Route for chanel
         */
        '<chanelId:alphanumeric>' => [
            array('format' => '<:empty>', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=wall;chanelId={1}', 'as' => 'chanel.wall_empty'),
            // Index of chanel
            array('format' => 'live.html', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=live;chanelId={1}', 'as' => 'chanel.live'),
            array('format' => 'videos.html', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=videos;chanelId={1}', 'as' => 'chanel.videos'),
            array('format' => 'wall.html', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=wall;chanelId={1}', 'as' => 'chanel.wall'),
            array('format' => '<:empty>', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=wall;chanelId={1}', 'as' => 'chanel.index'),
            array('format' => 'video-<videoId:alphanumeric>.html', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=video;chanelId={1};videoId={2}', 'as' => 'chanel.video')
        ],
        
        /**
         * Ajax route
         */
        'ajax' => [
            'chanel' => [
                array('format' => 'videos.html', 'method' => 'post', 'parameters' => 'controller=Site\ChanelController;action=ajaxVideos', 'as' => 'ajax.chanel.videos'),
                array('format' => 'subscribe.html', 'method' => 'post', 'parameters' => 'controller=Site\ChanelController;action=ajaxSubscribe', 'as' => 'ajax.chanel.subscribe'),
                array('format' => 'questions.html', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=ajaxQuestions', 'as' => 'ajax.chanel.questions'),
                array('format' => 'add-question.html', 'method' => 'any', 'parameters' => 'controller=Site\ChanelController;action=ajaxAddQuestion', 'as' => 'ajax.chanel.add-question')
            ],
            
            'advertising' => [
                ['<page:alphanumeric>/<group:alphanumeric>/<type:alphanumeric>.html', 'any', 'controller=AdvertisingController;action=get;page={1};group={2};type={3}', 'as' => 'get']
            ]
        ],
        
        /**
         * Route for manager
         */
        'manager' => [
            'chanel' => [
                array('format' => '<:empty>', 'method' => 'any', 'as' => 'manager.chanel.index', 'parameters' => 'controller=Manager\ChanelController;action=index'),
                array('format' => 'create', 'method' => 'any', 'as' => 'manager.chanel.create', 'parameters' => 'controller=Manager\ChanelController;action=create'),
                /* Config url for each chanel */
                '<chanelId:alphanumeric>' => [
                    array('format' => '<:empty>', 'method' => 'any', 'as' => 'manager.chanel.info', 'parameters' => 'controller=Manager\ChanelController;action=chanelInfo;chanelId={1}'),
                    array('format' => 'update', 'method' => 'any', 'as' => 'manager.chanel.update', 'parameters' => 'controller=Manager\ChanelController;action=update;chanelId={1}'),
                    array('format' => 'delete', 'method' => 'post', 'as' => 'manager.chanel.delete', 'parameters' => 'controller=Manager\ChanelController;action=delete;chanelId={1}'),
                    array('format' => 'create-live', 'method' => 'any', 'as' => 'manager.chanel.live.create', 'parameters' => 'controller=Manager\ChanelController;action=createLive;chanelId={1}'),
                    array('format' => 'update-live', 'method' => 'any', 'as' => 'manager.chanel.live.update', 'parameters' => 'controller=Manager\ChanelController;action=updateLive;chanelId={1}'),
                    array('format' => 'delete-live', 'method' => 'any', 'as' => 'manager.chanel.live.delete', 'parameters' => 'controller=Manager\ChanelController;action=deleteLive;chanelId={1}'),
                    array('format' => 'finish-live', 'method' => 'any', 'as' => 'manager.chanel.live.finish', 'parameters' => 'controller=Manager\ChanelController;action=finishLive;chanelId={1}')
                ]
            ]
        ],
        
        /**
         * Route for me (current logged user)
         */
        'user' => [
            //'profile' => [
            array('format' => 'profile', 'method' => 'any', 'as' => 'user.profile', 'parameters' => 'controller=User\AccountController;action=profile'),
            array('format' => 'update', 'method' => 'any', 'as' => 'user.profile.update', 'parameters' => 'controller=User\AccountController;action=update'),
            //]
        ]
    )
];