<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\Cache;

class StaticController extends AppController
{
    public $meta = ['title' => 'About', 'desc' => 'desc', 'keywords' => 'keywords'];

    public function index(): void
    {
        $this->view('pages/index', [
            'title' => 'Home',
            'get' => $_GET
        ]);
    }

    public function about(): void
    {
        $arr = ['привет', 'fylhtqwdww'];

        $cash = Cache::instance();

        $cash1 = $cash->get('title');
        if (!$cash1) {
            $cash->set('title', $arr, 100);
        }

        $this->view('pages/index', [
            'title' => 'About',
            'arrayName' => $cash->get('title')
        ]);
    }

    public function close(): void
    {
        $user = new UserModel();
        if (!$user::isAuth()) {
            redirect("/login");
        }
        $this->view('pages/index', [
            'title' => 'Close'
        ]);
    }

    public function services(): void
    {
//        self::$app->setProperty('title', 'name');
//        dpre(self::$app->getProperties());

        $this->view('pages/test', [
            'id' => $_GET['id']
        ]);
    }

}