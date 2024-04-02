<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookMoveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('login')->group(function () {
    Route::get('/', [UserController::class, 'login']);
    Route::post('/', [UserController::class, 'web_login'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [UserController::class, 'web_logout']);
    
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    
    Route::prefix('bibliography')->group(function () {
        Route::get('/', [BookController::class, 'index']);
        Route::get('/create', [BookController::class, 'create']);
        Route::post('/store', [BookController::class, 'store']);
        Route::get('/edit/{id}', [BookController::class, 'edit']);
        Route::post('/edit/{id}', [BookController::class, 'update']);
        Route::post('/delete/{id}', [BookController::class, 'destory']);
    });

    Route::get('borrowing_history', [BookMoveController::class, 'index']);

    
    Route::prefix('member')->group(function () {
        Route::get('/', [UserController::class, 'index'] );
        Route::get('/create', [UserController::class, 'create'] );
        Route::post('/store', [UserController::class, 'store'] );
        Route::get('/edit/{id}', [UserController::class, 'edit'] );
        Route::post('/edit/{id}', [UserController::class, 'update'] );
        Route::post('/delete/{id}', [UserController::class, 'destroy']);
    });
});

Route::middleware(['verifyDownloadSignature'])->group(function () {
    Route::get('/download/book/{book}', [BookController::class, 'download'])->name('download.book');
});