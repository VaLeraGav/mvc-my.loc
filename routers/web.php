<?php


use App\Application\Views\View;
use App\Controllers\PageController;
use App\Application\Router\Route;

//dd($_SERVER);

Route::get('/', PageController::class, 'index');
Route::get('/home', PageController::class, 'home');

Route::get('/contacts', PageController::class, 'contacts');
Route::post('/contacts', PageController::class, 'submit');

Route::get('/blog/(\w+)/(\d+)', function($category, $id){
    print $category . ':' . $id;
});

Route::get('/show/(\w+)', function ($name) {
        View::show('pages/show', [
        'name' => $name
    ]);
});

Route::all(
    [
        '/login' => [PageController::class],
        '/aut' => [PageController::class],
    ]
);