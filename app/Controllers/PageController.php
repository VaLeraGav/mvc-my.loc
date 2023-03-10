<?php

namespace App\Controllers;

use App\Application\Database\Connection;
use App\Application\Views\View;
use App\Models\UserModel;

class PageController
{
    public function index(): void
    {
        $db = new UserModel();
        $db = $db->findAll()->fetchAll();


//        $db = new UserModel();
//        $db->query('CREATE TABLE user
//(
//    id INT,
//    name VARCHAR(255) NOT NULL,
//    position VARCHAR(30),
//    birthday Date
//)');

//        $db = UserModel::setup()->query('SELECT * FROM user')->fetchAll();

        // dpre($db);

        View::show('pages/index', [
            'title' => 'Home'
        ]);
    }

    public function home(): void
    {
        View::show('pages/home', [
            'title' => $_GET
        ]);
    }

    public function contacts(): void
    {
        View::show('pages/contacts', [
            'title' => 'Contacts'
        ]);
    }

    public function submit(array $data)
    {
        dd($data);
    }
}