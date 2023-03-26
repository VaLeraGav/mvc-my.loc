<?php

namespace Core;

use Core\Libs\Registry;
use Core\Route;
use Core\Router;
use Core\Exceptions\ComponentNotFoundException;
use Core\Exceptions\ViewNotFoundException;

class App
{
    public static $app;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        try {
            new ErrorHandler();
            self::$app = Registry::instance();

            $this->getParams();
            $this->handle();
        } catch (\Exception $e) {
            throw new \Exception('App: ' . $e->getMessage());
        }
    }

    public function handle()
    {
        require_once ROOT . '/routers/web.php';
        $router = new Router();

        dpre(Route::list());
        $router->dispatch(Route::list());
    }

    protected function getParams()
    {
        $params = require_once CONF . '/params.php';
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                self::$app->setProperty($k, $v);
            }
        }
    }
}

