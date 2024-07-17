<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('app/create-tag', [AdminController::class, 'createTag']);
Route::get('app/get-tags', [AdminController::class, 'getTag']);
Route::post('app/edit-tag', [AdminController::class, 'editTag']);
Route::post('app/delete-tag', [AdminController::class, 'deleteTag']);
Route::post('app/upload', [AdminController::class, 'upload']);
Route::post('app/delete-image', [AdminController::class, 'deleteImage']);
Route::post('app/create-category', [AdminController::class, 'createCategory']);
Route::post('app/edit-category', [AdminController::class, 'editCategory']);
Route::get('app/get-categories', [AdminController::class, 'getCategories']);



Route::get('/', function () {
    return view('welcome');
});

Route::any('/{any}', function () {
    return view('welcome');
});
