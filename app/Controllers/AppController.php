<?php

namespace App\Controllers;

use App\Widgets\Currency\Currency;
use Core\App;
use Core\Base\Controller;

class  AppController extends Controller
{
    public function __construct()
    {
        App::$app->setProperty('currencies', Currency::getCurrencies());
        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));
    }

}