<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

define('ROOT', __DIR__); // начала папки
define('CONF', __DIR__ . '/config');

use App\Application\App;

$app = new App();
$app->run();
