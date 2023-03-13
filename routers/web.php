<?php

use App\Controllers\admin\AdminController;
use Core\Route;
use App\Controllers\LoginController;
use App\Controllers\StaticController;
use App\Controllers\RegistrationController;
use App\Controllers\ServicesController;

//dd($_SERVER);


Route::get('/', StaticController::class, 'index');

Route::get('/about', StaticController::class, 'about');

//Route::get('/about', StaticController::class, 'about');

//Route::get('/close', StaticController::class, 'close');
//
//Route::get('/services/(\w+)', ServicesController::class, 'contacts');
//
//// ---------------- logout / login  ----------------
//
//Route::get('/logout', LoginController::class, 'destroy');
//
//Route::get('/login', LoginController::class, 'index');
//
//Route::post('/login', LoginController::class, 'auth');
//
//// ---------------- registration ----------------
//
//Route::get('/registration', RegistrationController::class, 'index');
//
//Route::post('/registration', RegistrationController::class, 'registration');


Route::get('/admin$', AdminController::class, 'index');

//Route::get('/blog/(\w+)/(\d+)', function($category, $id){
//    print $category . ':' . $id;
//});
//Route::get('/show/(\w+)', function ($name) {
//        View::show('pages/show', [
//        'name' => $name
//    ]);
//});
//
//Route::all(
//    [
//        '/login' => [PageController::class],
//        '/aut' => [PageController::class],
//    ]
//);