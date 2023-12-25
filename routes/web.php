<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;

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


// Portal links
Route::get('/', [PortalController::class, 'index'])->name('portal');
Route::get('/articles', [PortalController::class, 'articles'])->name('portal.articles');
Route::get('/article/{article}/show', [PortalController::class, 'article'])->name('portal.article');
Route::post('/article/{article}/comment', [PortalController::class, 'comment'])->name('portal.article.comment');
Route::post('/article/search', [PortalController::class, 'search'])->name('portal.article.search');
Route::get('/author/{user}/articles', [PortalController::class, 'author_articles'])->name('portal.author.articles');


Route::group(['middleware' => ['auth','verified'] ,'namespace' => 'App\Http\Controllers\Admin','prefix' =>'admin','as'=>'admin.']
    ,function () {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        
        // users routes 
        Route::resource('users', AdminController::class)->except('show');
        Route::get('users/{user}/articles', [AdminController::class,'userArticles'])->name('user.articles');

        // article route
        Route::resource('articles', ArticleController::class);
        Route::get('articles/{article}/approve', [ArticleController::class,'approve'])->name('articles.approve');
        Route::get('articles/{article}/reject', [ArticleController::class,'reject'])->name('articles.reject');

        // comments route
        Route::resource('comments', CommentController::class);
        Route::get('comments/{comment}/approve', [CommentController::class,'approve'])->name('comments.approve');
        Route::get('comments/{comment}/reject', [CommentController::class,'reject'])->name('comments.reject');

        // roles route
        Route::resource('roles', RoleController::class);
        Route::get('roles/{role}/users', [RoleController::class,'roleUsers'])->name('role.users');
});


require __DIR__.'/auth.php';
