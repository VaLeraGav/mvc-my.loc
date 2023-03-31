<?php

use App\Controllers\admin\CacheController;
use App\Controllers\RegistrationController;
use Core\Route;
use App\Controllers\MainController;
use App\Controllers\CartController;
use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Controllers\SearchController;
use App\Controllers\AuthController;
use App\Controllers\admin\UserController as AdminUserController;
use App\Controllers\admin\MainController as AdminMainController;
use App\Controllers\admin\CategoryController as AdminCategoryController;
use App\Controllers\admin\OrderController;

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
    ['/signup', 'get', RegistrationController::class, 'index'],
    ['/signup', 'post', RegistrationController::class, 'signup'],
]);

// ---------------- admin ----------------

Route::group('/admin', [
    ['', 'get', AdminMainController::class, 'index'],
    ['/cache', 'get', CacheController::class, 'index'],
    ['/cache/delete', 'get', CacheController::class, 'delete']
]);

Route::group('/admin/user', [
    ['/login-admin', 'get', AdminUserController::class, 'index'],
    ['/login-admin', 'post', AdminUserController::class, 'login'],
    ['', 'get', AdminUserController::class, 'show'],
    ['/edit', 'get', AdminUserController::class, 'edit'],
    ['/edit', 'post', AdminUserController::class, 'update'],
    ['/add', 'get', AdminUserController::class, 'add'],
    ['/add', 'post', AdminUserController::class, 'signup'],
]);

Route::group('/admin/category', [
    ['', 'get', AdminCategoryController::class, 'index'],
    ['/delete', 'get', AdminCategoryController::class, 'delete'],
    ['/add', 'get', AdminCategoryController::class, 'add'],
    ['/add', 'post', AdminCategoryController::class, 'store'],
    ['/edit', 'get', AdminCategoryController::class, 'edit'],
    ['/edit', 'post', AdminCategoryController::class, 'update'],
]);

Route::group('/admin/order', [
    ['', 'get', OrderController::class, 'index'],
    ['/view', 'get', OrderController::class, 'viewAction'],
    ['/change', 'get', OrderController::class, 'change'],
    ['/delete', 'get', OrderController::class, 'delete'],
]);


//Route::get('/admin$', AdminMainController::class, 'index');
//Route::get('/admin/?', AdminMainController::class, 'index');
//Route::get('/admin/user/login-admin', AdminUserController::class, 'index');
//Route::post('/admin/user/login-admin', AdminUserController::class, 'login');

