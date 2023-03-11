<?php

namespace App\Application;

use App\Application\Router\Route;
use App\Application\Router\Router;
use App\Exceptions\ComponentNotFoundException;
use App\Exceptions\ViewNotFoundException;

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

