<?php

namespace Core;

class Route
{
    private static array $handler;

    public static function get(string $uri, $controller, $method = null): void
    {
        self::define('get', $uri, $controller, $method);
    }

    public static function post(string $uri, $controller, $method = null): void
    {
        self::define('post', $uri, $controller, $method);
    }

    public static function define(string $type, string $uri, $controller, $method): void
    {
        $pattern = '/^' . str_replace('/', '\/', $uri) . '$/';
        self::$handler[] = [
            'uri' => $uri,
            'pattern' => $pattern,
            'type' => $type,
            'controller' => $controller,
            'method' => $method,
        ];
    }

    public static function all(array $routers): void
    {
        foreach ($routers as $url => $item) {
            $controller = $item[0];
            // по умолчанию
            $method = $item[1] ?? 'index';
            $type = $item[2] ?? 'get';

            self::define($type, $url, $controller, $method);
        }
    }

    public static function list(): array
    {
        return self::$handler;
    }

    public static function group($head, array $routers)
    {
        foreach ($routers as $item) {
            $controller = $item[2];
            $method = $item[3] ?? 'index';
            $type = $item[1];
            $url = $head . $item[0];
            self::define($type, $url, $controller, $method);
        }
    }
}