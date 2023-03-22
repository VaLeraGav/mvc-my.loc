<?php

namespace App\Controllers;

use App\Widgets\Currency\Currency;
use Core\App;
use Core\Base\Controller;
use Core\Base\Model;
use Core\Cache;

class  AppController extends Controller
{
    public function __construct()
    {
        App::$app->setProperty('currencies', Currency::getCurrencies());
        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));

        App::$app->setProperty('cats', self::cacheCategory());
    }

    public static function cacheCategory()
    {
        $cache = Cache::instance();
        $cats = $cache->get('cats');
        if(!$cats) {
            $cats = Model::requestArr("SELECT * FROM category", 'id');
            $cache->set('cats', $cats);
        }
        return $cats;
    }

}