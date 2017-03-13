<?php
return [
    'uses' => 'tests',

    'connections' => [
        'tests' => [
            'user' => 'root',
            'password' => '',
            'port' => '80',
            'host' => 'localhost',
            'type' => 'mysql', //pgsql
            'dbname' => 'tests',
            'encoding' => 'utf8'
        ],
    ]
];
