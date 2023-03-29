<?php

namespace App\Controllers\admin;

use App\Models\UserModel;
use Core\Base\Controller;
use Core\Logger;

class AppController extends Controller
{
    public $layout = 'admin';

    public function __construct()
    {
        if (!UserModel::isAdmin() && $_SERVER['REQUEST_URI'] !== '/admin/user/login-admin') {
            redirect(ADMIN . '/user/login-admin');
        }
    }

    protected function getRequestID($get = true, $id = 'id')
    {
        $data = ($get) ? $_GET : $_POST;

        return $data[$id];
    }

}