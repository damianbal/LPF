<?php 

return [
    /**
     * App
     */
    'app' => [
        'default_action' => 'Home@index'
    ],

    /**
     * Database settings
     */
    'database' => [
        'driver' => 'LPF\\Framework\\Database\\PDOConnection',
        'port' => '3306',
        'host' => 'mariadb',
        'user' => 'lpf',
        'pass' => 'lpf123',
        'dbname' => 'lpf',
    ],

    /**
     * Template settings
     */
    'template' => [
        'driver' => 'LPF\\Framework\\Template\\TwigTemplate',
        'cache' => false,
    ],

    /**
     * Pagination settings
     */
    'pagination' => [
        'results_per_page' => 3,
    ],

    /**
     * Filesystem settings
     */
    'filesystem' => [
        'driver' => 'LPF\\Framework\\Filesystem\\LocalStorage',
        'path' => __DIR__ . '/Storage' . '/',
    ]
];