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
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }

}