<?php

define("ROOT", dirname(__DIR__));
define('CONF', ROOT . '/config');
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("VIEW", ROOT . '/app/Views');
define("TMP", ROOT . '/tmp');
define("CACHE", ROOT . '/tmp/cache');


$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$app_path = preg_replace("#[^/]+$#", '', $app_path);
$app_path = str_replace('public/', '', $app_path);
define("PATH", $app_path);
define("ADMIN", '/admin');

define("LAYOUT", 'watches');

define("DEBUG", 1);    // режим разработки 1-разработки 0-чистовик