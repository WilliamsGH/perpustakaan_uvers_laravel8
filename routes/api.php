<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookMoveController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('/user')->group(function () {
        
    Route::post('/login', [UserController::class, 'api_login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/get_user_info', [UserController::class, 'get_user_info']);
        Route::get('/get_wish_list', [UserController::class, 'get_wish_list']);
        Route::post('/add_wish_list', [UserController::class, 'add_wish_list']);
        Route::delete('/delete_wish_list', [UserController::class, 'delete_wish_list']);
        Route::post('/borrow_book', [UserController::class, 'borrow_book']);
        Route::post('/return_book', [UserController::class, 'return_book']);
        Route::get('/get_book_list', [UserController::class, 'get_book_list']);
        Route::get('/get_history', [UserController::class, 'get_history']);
        Route::post('/change_password', [UserController::class, 'change_password']);
    });
});


Route::prefix('/book_move')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/update_rating', [BookMoveController::class, 'update_rating']);
    });
});

Route::prefix('/book')->group(function () {
    Route::get('/get_book_list', [BookController::class, 'get_book_list']);
    Route::get('/get_book_detail', [BookController::class, 'get_book_detail']);
});

Route::prefix('/category')->group(function () {
    Route::get('/get_category_list', [CategoryController::class, 'get_category_list']);
});