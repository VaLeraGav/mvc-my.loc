<?php

namespace App\Application\Views;

use App\Exceptions\ComponentNotFoundException;
use App\Exceptions\ViewNotFoundException;

class View
{
    private static string $pathToViews = ROOT . '/views';

    public static function show(string $view, array $params = []): void
    {
        extract($params);

        $path = self::$pathToViews . "/$view.view.php";

        if (!file_exists($path)) {
            throw new ViewNotFoundException("View ($view) not found");
        }
        include $path;
    }

    public static function component(string $component): void
    {
        $path = self::$pathToViews . "/components/$component.component.php";

        if (!file_exists($path)) {
            throw new ComponentNotFoundException("Component ($component) not found");
        }
        include $path;
    }
}
