<?php

namespace Core;

class Router
{

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
                die();
            }
        }
        require VIEW . '/errors/404.php';
        header("HTTP/1.1 404 Not Found");
        die();
    }

    protected static function filter(array $routes, string $type = 'get'): array
    {
        return array_filter($routes, function ($route) use ($type) {
            return $route['type'] === $type;
        });
    }

    protected static function controller(array $route, $params)
    {
        array_shift($params);
        if (is_object($route['controller'])) {
            call_user_func_array($route['controller'], array_values($params));
            return;
        }

        $controller = new $route['controller']();
        $method = $route['method'];
        // dpre($_POST);
        if (!empty($_POST)) {
            $controller->$method($_POST);
        } else {
            $controller->$method(...$params);
        }
    }
}
