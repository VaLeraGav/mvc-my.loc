<?php

namespace App\Application\Router;

class Router
{
    use RouterHelper;

    public function dispatch(array $routes): void
    {
        // dpre($_SERVER);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $type = $requestMethod === 'POST' ? 'post' : 'get';

        $urlFull = $_SERVER['REQUEST_URI'];
        $split_url = explode('?', $urlFull);
        $urlPath = $split_url[0];

        $filteredRouters = self::filter($routes, $type);

        foreach ($filteredRouters as $route) {
            $pattern = $route['pattern'];
            if (preg_match($pattern, $urlPath, $params)) // сравнение идет через регулярное выражение
            {
                self::controller($route, $params);
            } else {
                header("HTTP/1.1 404 Not Found");
            }
        }
    }

}
