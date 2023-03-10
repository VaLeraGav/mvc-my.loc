<?php

namespace App\Application\Router;

trait  RouterHelper
{
    protected static function filter(array $routes, string $type = 'get'): array
    {
        return array_filter($routes, function ($route) use ($type) {
            return $route['type'] === $type;
        });
    }

    protected static function controller(array $route, $params)
    {
        if (is_object($route['controller'])) {
            // echo $route['controller']();
            // удаляем первый элемент из массива $params который содержит всю найденную строку
            array_shift($params);
            call_user_func_array($route['controller'], array_values($params));
            return;
        }

        $controller = new $route['controller']();
        $method = $route['method'];
        if (!empty($_POST)) {
            $controller->$method($_POST);
        } else {
            $controller->$method();
        }
    }
}