<?php
return [
    'develop' => true,

    'languages' => array(
        'default' => 'vi',
        'folder'	=> 'languages'
    ),

    /**
     * Config setting core for MVC pattern
     *
     */
    'MVC' => [
        /**
         * Action prefix setting
         * This setting will be define the name of action, which will be call from pattern MVC to controller method
         * Example: my prefix is "action" and action is "index" the MVC will call actionindex in controller
         */
        'action-prefix' => 'action',
        /**
         * Action ucfirst setting
         * This setting will be define the name of action, which will be call from pattern MVC to controller method
         * Example: my ucfirst is TRUE and action is "index" the MVC will call actionIndex in controller
         */
        'action-ucfirst' => true
    ],

    'pattern' => \Overfull\Patterns\MVC\PatternHandler::class,

    /**
     * Setting for otp
     */
    'otp-extension' => 'php',
    'otp-redirect-title' => 'Đang chuyển hướng ...',

    /**
     * My custom setting
     */
    //'socket-url' => 'https://chat-share-overfull.herokuapp.com',
    'socket-url' => 'http://localhost:8080',

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
    
//     'error-handler' => [
//         'controller' => 'ErrorsController',
//         'action' => 'error'
//     ]
];
