<?php

namespace Core\Base;

use Core\Exceptions\ComponentNotFoundException;
use Core\Exceptions\ViewNotFoundException;

class View
{
    public $layout;
    public $view;
    public $meta = [];

    public function __construct($layout = '', $view = '', $meta = '')
    {
        $this->view = $view;
        $this->meta = $meta;
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
    }

    public function renderView($data = []): void
    {
        if (is_array($data)) {
            extract($data);
        }

        $viewFile = VIEW . "/$this->view.view.php";

        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        } else {
            throw new \Exception("На найден вид {$viewFile}", 500);
        }

        if (false !== $this->layout) {
            $layoutFile = VIEW . "/layouts/{$this->layout}.php";
            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("На найден шаблон {$this->layout}", 500);
            }
        }
    }

    public function getMeta()
    {
        $output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
        $output .= '<meta name="description" content="' . $this->meta['desc'] . '">' . PHP_EOL;
        $output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
        return $output;
    }

    public static function component(string $component): void
    {
        $path = VIEW . "/components/$component.component.php";

        if (!file_exists($path)) {
            throw new ComponentNotFoundException("Component ($component) not found");
        }
        include $path;
    }
}
