<?php

namespace App\Controllers\admin;

use Core\Cache;

class CacheController extends AppController
{

    public function index()
    {
        $this->setMeta('Очистка кеша');
        $this->view('admin/pages/cache');
    }

    public function delete()
    {
        $key = isset($_GET['key']) ? $_GET['key'] : null;

        $cache = Cache::instance();
        switch ($key) {
            case 'category':
                $cache->delete('cats');
                $cache->delete('ishop_menu');
                break;
            case 'filter':
                $cache->delete('filter_group');
                $cache->delete('filter_attrs');
                break;
        }

        $_SESSION['success'] = 'Выбранный кеш удален';
        redirect();
    }
}