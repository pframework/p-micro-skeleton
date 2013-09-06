<?php

// if using the php built-in server, and file exists route to it:
if (php_sapi_name() == 'cli-server'
    && !in_array($_SERVER['REQUEST_URI'], ['/', 'index.php'])
    && file_exists(__DIR__ . $_SERVER['REQUEST_URI'])) {
    return false;
}

// get MODE from environment, REDIRECT_MODE for cgi based deployment
define('MODE', (getenv('MODE') ? getenv('MODE') : ((getenv('REDIRECT_MODE')) ? getenv('REDIRECT_MODE') : 'production')));
define('PATH', __DIR__ . '/');

// composer autoloader
require PATH . '/vendor/autoload.php';

// application
$app = new P\Application([
    'application' => [
        'features' => [
            'P\Feature\PHTMLView'
        ]
    ],
    'phtml_view' => [
        'paths' => [__DIR__ . '/view/']
    ]
]);

$app['home'] = [
    'GET /',
    function() {
        // [view_name, [array of variables]]
        // return ['index', ['message' => 'Hello World']];
        echo 'hi';
    }
];

$app['hello-world'] = [
    'GET /hello/:name',
    function($name) {
        return ['hello.phtml', ['name' => urldecode($name)]];
    }
];

$app->run();