<?php

use App\controllers\AmoController;
use App\controllers\AuthController;
use App\controllers\BitrixController;
use App\controllers\PageController;
use App\controllers\RegisterController;
use App\controllers\BlogController;
use App\controllers\DiaryController;
use App\controllers\HomeController;
use App\controllers\LibraryController;
use App\middleware\AuthMiddleware;
use App\middleware\GuestMiddleware;
use App\router\Route;



return [
    Route::get('/blog/home', [HomeController::class, 'index'], [GuestMiddleware::class]),
    //Route::get('/blog/amo', [AmoController::class, 'index'], [GuestMiddleware::class]),
    Route::get('/blog/diary', [DiaryController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/blog/diary', [DiaryController::class, 'store']),
    Route::get('/blog/library', [LibraryController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/blog/library', [LibraryController::class, 'store']),
    Route::post('/blog/delete', [LibraryController::class, 'delete']),
    Route::post('/blog/read', [LibraryController::class, 'read']),
    Route::get('/blog/register', [RegisterController::class, 'register'], [AuthMiddleware::class]),
    Route::post('/blog/register', [RegisterController::class, 'add']),
    Route::get('/blog/auth', [AuthController::class, 'index'], [AuthMiddleware::class]),
    Route::post('/blog/auth', [AuthController::class, 'auth']),
    Route::post('/blog/logout', [AuthController::class, 'logout']),
    Route::post('/blog/page', [PageController::class, 'index']),
    Route::post('/blog/edit', [PageController::class, 'edit']),
    Route::post('/blog/patch', [PageController::class, 'patch']),
    Route::post('/blog/deletePage', [PageController::class, 'delete']),
    Route::get('/blog/blog', [AmoController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/blog/blog', [AmoController::class, 'addLeadComplex'], [GuestMiddleware::class]),
    Route::post('/blog/lead', [AmoController::class, 'lead'], [GuestMiddleware::class]),
    Route::post('/blog/editLead', [AmoController::class, 'edit'], [GuestMiddleware::class]),
    Route::post('/blog/patch', [AmoController::class, 'patch'], [GuestMiddleware::class]),

];