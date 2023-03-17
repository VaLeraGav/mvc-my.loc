<?php

namespace App\Controllers;

use App\Models\UserModel;
use Core\Base\Controller;

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
        $this->view('pages/index', [
            'title' => 'About'
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