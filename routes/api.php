<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
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

Route::post('register', [AuthorController::class, 'regsiter']);
Route::post('login', [AuthorController::class, 'login']);
Route::get('list/book', [BookController::class, 'listBook']);

Route::group(['middleware' => ['auth:api']], function (){
    Route::get('profile', [AuthorController::class, 'profile']);
    Route::post('logout', [AuthorController::class, 'logout']);

    Route::post('create/book', [BookController::class, 'create']);
    Route::get('author/book', [BookController::class, 'authorBook']);
    Route::get('single/book/{book_id}', [BookController::class, 'singleBook']);
    Route::post('update/book/{book_id}', [BookController::class, 'updateBook']);
    Route::get('delete/book/{book_id}', [BookController::class, 'deleteBook']);



});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
