<?php

/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config\Config([
//    'database' => [
//        'adapter' => 'mysql',
//        'host' => '172.28.0.3',
//        'username' => 'katarinakat',
//        'password' => 'Sifra123!',
//        'dbname' => 'files_database',
//    ],
    'database' => [
        'adapter' => 'mysql',
        'host' => '172.18.0.4',
        'username' => 'katarinakat',
        'password' => 'Sifra123!',
        'dbname' => 'api_database',
        'charset'     => 'utf8mb4',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/',
    ]
]);


