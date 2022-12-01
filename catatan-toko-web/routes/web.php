<?php

use App\Http\Controllers\ImageController;
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
Route::get('image/{filename}', [ImageController::class, 'showImage'])->where('filename', '.*')->name('showimage');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home', [App\Http\Controllers\StoreController::class, 'store'])->name('post.store');
Route::delete('/delete/{id}', [\App\Http\Controllers\StoreController::class, 'destroy'])->name('delete.store');
Route::resource('/admin', \App\Http\Controllers\AdminController::class);
Route::get('/superAdmin', [\App\Http\Controllers\SuperAdminController::class, 'index'])->name('superAdmin');
Route::post('/superAdmin', [App\Http\Controllers\SuperAdminController::class, 'store'])->name('superAdmin.store');
Route::get('image/{file}', [\App\Http\Controllers\SuperAdminController::class, 'download'])->name('download');
