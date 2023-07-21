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
//Creation of Article
Route::get('/article/create',[App\Http\Controllers\ArticlesController::class, 'create'])->name('article.create');
Route::post('/article/store',[App\Http\Controllers\ArticlesController::class, 'store'])->name('articles.store');

//Sending Article to blade
Route::get('/', [App\Http\controllers\ArticlesController::class, 'index']);
Route::get('/article/{id}',[App\Http\controllers\ArticlesController::class, 'show'])->name('article.show');
Route::get('/my_article',[App\Http\controllers\ArticlesController::class, 'showPersonal'])->name('article.showPersonal');

//Removal of Article
Route::delete('/my_article/{id}',[App\Http\controllers\ArticlesController::class, 'destroy'])->name('article.remove');

//Edit or update for article
Route::get('/my_article/edit/{id}',[App\Http\controllers\ArticlesController::class, 'edit'])->name('article.edit');
Route::post('/my_article/update/{id}',[App\Http\Controllers\ArticlesController::class, 'update'])->name('articles.update');