<?php

namespace App\Widgets\Menu;


use Core\App;
use Core\Base\Model;
use Core\Cache;

class Menu
{

    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;
    protected $container = 'ul';
    protected $class = 'menu';
    protected $table = 'category';
    protected $cache = 3600;
    protected $cackeKey = 'ishop_menu';
    protected $attrs = [];
    protected $prepend = '';

    public function __construct($options = [])
    {
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';
        $this->getOptions($options);
        $this->run();
    }

    protected function getOptions($options)
    {
        foreach ($options as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    protected function run()
    {
        $cache = Cache::instance();
        $this->menuHtml = $cache->get($this->cackeKey);

        if (!$this->menuHtml) {
            $this->data = App::$app->getProperty('cats');

            if (!$this->data) {
                $arr = Model::queryNew("SELECT * FROM {$this->table}");
                $this->data = Model::changeKey($arr, 'id');
            }

            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
//            $this->menuHtml .= "<li><a href='#'>Blog</a></li>";
//            $this->menuHtml .= "<li><a href='#'>Contact</a></li>";
            if ($this->cache) {
                $cache->set($this->cackeKey, $this->menuHtml, $this->cache);
            }
        }
        $this->output();
    }

    protected function output()
    {
        $attrs = '';
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $k => $v) {
                $attrs .= " $k = '$v' ";
            }
        }
        echo "<{$this->container} class='{$this->class}' $attrs>";
        echo $this->prepend;
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    protected function getTree()
    {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    // $category, $tab, $id - передаются в шаблон
    protected function catToTemplate($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

}