<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\Base\Controller;
use Core\Cache;

class StaticController extends Controller
{
    public $meta = ['title' => 'About', 'desc' => 'desc', 'keywords' => 'keywords'];

    public function index(): void
    {
        $this->view('pages/index', [
            'title' => 'Home'
        ]);
    }

    public function about(): void
    {
        $name = ['андрей', 'матвей', 'n123'];

//        $date = Cache::get('new');
//        var_dump($date);
//        if(!$date) {
//            Cache::set('new', $name, 10);
//        }
//        var_dump($date);

        $this->view('pages/index', [
            'title' => 'About',
            'arrayName' => $name
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
}