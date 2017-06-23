<?php
return [
    'develop' => true,

    'languages' => array(
        'default' => 'vi',
        'folder'	=> 'languages'
    ),

    'timezone' => 'Asia/Saigon',

    'pattern' => \Overfull\Patterns\MVC\PatternHandler::class,

    /**
     * Setting for otp
     */
    'otp-extension' => 'php',
    
    'otp-redirect-title' => 'Đang chuyển hướng ...',

    /**
     * Setting for route
     */
    'route-compare' => 'relative', // absolute

    /*
     * ------------------------------------------------------------------
     * Setting for errors and debug
     * ------------------------------------------------------------------
     */
    'error-display' => true,
    
//    'error-handler' => [
//        'controller' => 'ErrorsController',
//        'action' => 'error'
//    ]
];
