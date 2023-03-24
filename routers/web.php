<?php

use App\Controllers\admin\AdminController;
use App\Controllers\CartController;
use App\Controllers\CategoryController;
use App\Controllers\CurrencyController;
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

Route::get('/cart/add', CartController::class, 'add');

Route::get('/cart/show', CartController::class, 'show');

Route::get('/cart/delete', CartController::class, 'delete');

Route::get('/cart/clear', CartController::class, 'clear');

Route::get('/search', SearchController::class, 'index');

Route::get('/search/typeahead', SearchController::class, 'typeahead');

Route::get('/category/([a-z0-9-]+)/?', CategoryController::class, 'index');

// ---------------- logout / login  ----------------

Route::get('/user/login', AuthController::class, 'index');

Route::post('/user/login', AuthController::class, 'login');

Route::get('/user/logout', AuthController::class, 'destroy');

// ---------------- registration ----------------

Route::get('/user/signup', RegistrationController::class, 'index');

Route::post('/user/signup', RegistrationController::class, 'registration');

// ---------------- admin ----------------

Route::get('/admin$', AdminController::class, 'index');
