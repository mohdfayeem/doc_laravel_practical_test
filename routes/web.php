<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/admin/add-category', [App\Http\Controllers\HomeController::class, 'addCategory']);
Route::match(['get', 'post'], '/admin/edit-category/{id}', [App\Http\Controllers\HomeController::class, 'editCategory']);
Route::post('/admin/delete-subcategory', [App\Http\Controllers\HomeController::class, 'deleteSubCategory']);
Route::post('/admin/delete-category', [App\Http\Controllers\HomeController::class, 'deleteCategory']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
