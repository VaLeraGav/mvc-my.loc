<?php

namespace App\Application;


use App\Application\Router\Route;
use App\Application\Router\Router;

class App
{
    public function run(): void
    {
        try {
            session_start();
            $this->handle();
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function handle()
    {
        require_once ROOT . '/routers/web.php';
        $router = new Router();

        // dpre(Route::list());

        $router->dispatch(Route::list());
    }
}

