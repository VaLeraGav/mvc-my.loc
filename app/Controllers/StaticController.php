<?php

namespace App\Controllers;

use Core\Base\Controller;

class StaticController extends Controller
{
    // public $layout = 'other';

    public function index(): void
    {
        $this->view('pages/index', [
            'title' => 'Home'
        ]);
    }

    public function about(): void
    {
        $this->setMeta('About', "desc", 'keywords');
        $this->view('pages/index', [
            'title' => 'About'
        ]);
    }

//    public function close(): void
//    {
//        View::show('pages/index', [
//            'title' => 'close'
//        ]);
//    }
}