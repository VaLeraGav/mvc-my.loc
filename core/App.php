<?php

namespace Core;

use Core\Route;
use Core\Router;
use Core\Exceptions\ComponentNotFoundException;
use Core\Exceptions\ViewNotFoundException;

class App
{
    public function run(): void
    {
        try {
            $this->handle();

        } catch (ViewNotFoundException|ComponentNotFoundException $e) {
            throw new \Exception('NotFound' . $e->getMessage()); // ?
        }
    }

    public function handle()
    {
        new ErrorHandler();
        require_once ROOT . '/routers/web.php';
        $router = new Router();

        // dpre(Route::list());
        $router->dispatch(Route::list());
    }
}

