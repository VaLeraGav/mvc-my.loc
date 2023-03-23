<?php

use App\Controllers\admin\AdminController;
use App\Controllers\CartController;
use App\Controllers\CurrencyController;
use App\Controllers\ProductController;
use Core\Route;
use App\Controllers\AuthController;
use App\Controllers\MainController;
use App\Controllers\RegistrationController;

//dd($_SERVER);

Route::get('/', MainController::class, 'index');

Route::get('/close', MainController::class, 'close');

Route::get('/currency/change', MainController::class, 'changeCurrency');


Route::get('/product/([a-z0-9-]+)/?', function ($alias) {
    $app = new ProductController();
    $app->index($alias);
});

Route::get('/cart/add', CartController::class, 'add');

Route::get('/cart/show', CartController::class, 'show');

Route::get('/cart/delete', CartController::class, 'delete');

Route::get('/cart/clear', CartController::class, 'clear');

// ---------------- logout / login  ----------------

Route::get('/login', AuthController::class, 'index');

Route::post('/login', AuthController::class, 'login');

Route::get('/logout', AuthController::class, 'destroy');

// ---------------- registration ----------------

Route::get('/registration', RegistrationController::class, 'index');

Route::post('/registration', RegistrationController::class, 'registration');

Route::get('/admin$', AdminController::class, 'index');
