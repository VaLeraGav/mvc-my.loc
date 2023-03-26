<?php

use App\Controllers\admin\AdminController;
use App\Controllers\CartController;
use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Controllers\SearchController;
use Core\Route;
use App\Controllers\AuthController;
use App\Controllers\MainController;
use App\Controllers\RegistrationController;

//dd($_SERVER);

Route::get('/', MainController::class, 'index');

Route::get('/close', MainController::class, 'close');

Route::get('/currency/change', MainController::class, 'changeCurrency');

Route::get('/product/([a-z0-9-]+)/?', ProductController::class, 'index');

Route::get('/category/([a-z0-9-]+)/?', CategoryController::class, 'index');

Route::group('/cart', [
    ['/view', 'get', CartController::class, 'viewAction'],
    ['/clear', 'get', CartController::class, 'clear'],
    ['/checkout', 'post', CartController::class, 'checkout'],
    ['/add', 'get', CartController::class, 'add'],
    ['/show', 'get', CartController::class, 'show'],
    ['/delete', 'get', CartController::class, 'delete'],
]);

Route::group('/search', [
    ['', 'get', SearchController::class, 'index'],
    ['/typeahead', 'get', SearchController::class, 'typeahead'],
]);

Route::group('/user', [
    ['/login', 'get', AuthController::class, 'index'],
    ['/login', 'post', AuthController::class, 'login'],
    ['/logout', 'get', AuthController::class, 'destroy'],
    ['/signup', 'get', AuthController::class, 'index'],
    ['/signup', 'post', AuthController::class, 'registration'],

]);

// ---------------- admin ----------------

Route::get('/admin$', AdminController::class, 'index');



