<?php

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

Route::get('/', function () {
    return view('main');
});

Route::get('/articles', function () {
    return view('articles');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Article
Route::get('/articles/create',[App\Http\Controllers\ArticlesController::class, 'create'])->name('article.create');
Route::post('/articles/store',[App\Http\Controllers\ArticlesController::class, 'store'])->name('articles.store');
