<?php

namespace App\Controllers\admin;

use App\Models\UserModel;
use Core\Base\Controller;

class AppController extends Controller
{
    public $layout = 'admin';

    public function __construct()
    {
        dpre($_POST);
        if (!UserModel::isAdmin() &&  $_SERVER['REQUEST_URI'] !== '/admin/user/login-admin') {
            redirect(ADMIN . '/user/login-admin');
        }
    }
}