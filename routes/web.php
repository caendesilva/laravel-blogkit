<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReadmeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

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
    return view('welcome', [
        'posts' => Post::count()
    ]);
})->name('home');


Route::resource('posts', PostController::class);
Route::post('/posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
Route::post('/posts/{post}/unpublish', [PostController::class, 'unpublish'])->name('posts.unpublish');

Route::resource('comments', CommentController::class)->only([
    'edit',
    'destroy',
]);

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth', 'can:access-dashboards'])->name('dashboard');

if (config('blog.readme')) {
    Route::get('/readme', ReadmeController::class);
}

require __DIR__.'/auth.php';