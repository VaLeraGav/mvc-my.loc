<?php

namespace Core\Base;

abstract class Controller
{
    public $prefix;
    public $layout;
    public $meta = ['title' => '', 'desc' => '', 'keywords' => ''];

    public function view($view, $params = []): void
    {
        $viewObject = new View($this->layout, $view, $this->meta);
        $viewObject->renderView($params);
    }

    public function setMeta($title = '', $desc = '', $keywords = ''): void
    {
        $this->meta['title'] = h($title);
        $this->meta['desc'] = h($desc);
        $this->meta['keywords'] = h($keywords);
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function loadView($view, $vars = [])
    {
        extract($vars);
        require APP . "/Views/{$view}.php";
        die;
    }
}