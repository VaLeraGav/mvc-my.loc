<?php

use App\Controllers\admin\CacheController;
use App\Controllers\admin\CurrencyController;
use App\Controllers\admin\FilterController;
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
use App\Controllers\admin\ProductController as AdminProductController;
use App\Controllers\admin\OrderController;

//dd($_SERVER);

Route::get('/', MainController::class, 'index');

Route::get('/close', MainController::class, 'close');

Route::get('/currency/change', MainController::class, 'changeCurrency');

Route::get('/product/([a-z0-9-]+)/?', ProductController::class, 'index');

Route::get('/category/([a-z0-9-]+)/?', CategoryController::class, 'index');

Route::controller('/cart', CartController::class, [
    ['/view', 'get', 'viewAction'],
    ['/clear', 'get', 'clear'],
    ['/checkout', 'post', 'checkout'],
    ['/add', 'get', 'add'],
    ['/show', 'get', 'show'],
    ['/delete', 'get', 'delete'],
]);

Route::controller('/search', SearchController::class, [
    ['', 'get', 'index'],
    ['/typeahead', 'get', 'typeahead'],
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

Route::controller('/admin/user', AdminUserController::class, [
    ['/login-admin', 'get', 'index'],
    ['/login-admin', 'post', 'login'],
    ['', 'get', 'show'],
    ['/edit', 'get', 'edit'],
    ['/edit', 'post', 'update'],
    ['/add', 'get', 'add'],
    ['/add', 'post', 'signup'],
]);

Route::controller('/admin/category', AdminCategoryController::class, [
    ['', 'get', 'index'],
    ['/delete', 'get', 'delete'],
    ['/add', 'get', 'add'],
    ['/add', 'post', 'store'],
    ['/edit', 'get', 'edit'],
    ['/edit', 'post', 'update'],
]);

Route::controller('/admin/order', OrderController::class, [
    ['', 'get', 'index'],
    ['/view', 'get', 'viewAction'],
    ['/change', 'get', 'change'],
    ['/delete', 'get', 'delete'],
]);

Route::controller('/admin/product', AdminProductController::class, [
    ['', 'get', 'index'],
    ['/add', 'get', 'add'],
    ['/add', 'post', 'store'],
    ['/related-product', 'get', 'related'],
    ['/add-image', 'post', 'addImage'],
    ['/edit', 'get', 'edit'],
    ['/edit', 'post', 'update'],
    ['/delete-gallery', 'post', 'deleteGallery'],
    ['/delete', 'get', 'delete'],
]);

Route::controller('/admin/filter', FilterController::class, [
    ['/attribute', 'get', 'attribute'],
    ['/attribute-group', 'get', 'attributeGroup'],
    ['/attribute-delete', 'get', 'attributeDelete'],
    ['/attribute-add', 'get', 'attributeAdd'],
    ['/attribute-add', 'post', 'attributeStore'],
    ['/attribute-edit', 'get', 'attributeEdit'],
    ['/attribute-edit', 'post', 'attributeUpdate'],

    ['/group-delete', 'get', 'groupDelete'],
    ['/group-add', 'get', 'groupAdd'],
    ['/group-add', 'post', 'groupStore'],
    ['/group-edit', 'get', 'groupEdit'],
    ['/group-edit', 'post', 'groupUpdate'],
]);

Route::controller('/admin/currency', CurrencyController::class, [
    ['', 'get', 'index'],
    ['/add', 'get', 'add'],
    ['/add', 'post', 'store'],
    ['/edit', 'get', 'edit'],
    ['/edit', 'post', 'update'],
    ['/delete', 'get', 'delete']
]);


//Route::get('/admin$', AdminMainController::class, 'index');
//Route::get('/admin/?', AdminMainController::class, 'index');
//Route::get('/admin/user/login-admin', AdminUserController::class, 'index');
//Route::post('/admin/user/login-admin', AdminUserController::class, 'login');

