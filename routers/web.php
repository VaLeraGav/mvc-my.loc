<?php

use App\Controllers\admin\AdminController;
use Core\Route;
use App\Controllers\AuthController;
use App\Controllers\MainController;
use App\Controllers\RegistrationController;

//dd($_SERVER);

Route::get('/', MainController::class, 'index');

Route::get('/about', MainController::class, 'about');

Route::get('/close', MainController::class, 'close');

Route::get('/single', MainController::class, 'single');

// ---------------- logout / login  ----------------

Route::get('/login', AuthController::class, 'index');

Route::post('/login', AuthController::class, 'login');

Route::get('/logout', AuthController::class, 'destroy');

// ---------------- registration ----------------

Route::get('/registration', RegistrationController::class, 'index');

Route::post('/registration', RegistrationController::class, 'registration');

Route::get('/admin$', AdminController::class, 'index');
