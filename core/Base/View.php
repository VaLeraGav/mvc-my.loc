<?php

namespace Core\Base;

use Core\Exceptions\ComponentNotFoundException;
use Core\Exceptions\ViewNotFoundException;

class View
{
    private static string $pathToViews = VIEW;

    public static function show(string $view, array $params = []): void
    {
        if (is_array($params)) {
            extract($params);
        }

        $viewFile = self::$pathToViews . "/$view.view.php";

        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        } else {
            throw new \Exception("На найден вид {$viewFile}", 500);
        }

        $layoutFile = VIEW . "/layouts/default.php";
        if (is_file($layoutFile)) {
            require_once $layoutFile;
        } else {
            throw new \Exception("На найден шаблон {default}", 500);
        }
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
