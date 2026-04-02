<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;

// Front
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Front\LikeController;

// Author
use App\Http\Controllers\Author\PostController as AuthorPostController;

// Editor
use App\Http\Controllers\Editor\PostReviewController;

// Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Protected Blog System Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Like & Comment
    |--------------------------------------------------------------------------
    */
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
        ->middleware('permission:posts.like')
        ->name('posts.like');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->middleware('permission:comments.create')
        ->name('comments.store');

    /*
    |--------------------------------------------------------------------------
    | Author Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('author')
        ->name('author.')
        ->middleware('role:Author')
        ->group(function () {

            Route::resource('posts', AuthorPostController::class);

            Route::post('posts/{post}/submit', [AuthorPostController::class, 'submit'])
                ->middleware('permission:posts.submit')
                ->name('posts.submit');
        });

    /*
    |--------------------------------------------------------------------------
    | Editor Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('editor')
        ->name('editor.')
        ->middleware('role:Editor|Super Admin')
        ->group(function () {

            Route::get('reviews', [PostReviewController::class, 'index'])->name('reviews.index');
            Route::get('reviews/{post}', [PostReviewController::class, 'show'])->name('reviews.show');

            Route::post('reviews/{post}/approve', [PostReviewController::class, 'approve'])
                ->middleware('permission:posts.approve')
                ->name('reviews.approve');

            Route::post('reviews/{post}/reject', [PostReviewController::class, 'reject'])
                ->middleware('permission:posts.review')
                ->name('reviews.reject');

            Route::post('reviews/{post}/publish', [PostReviewController::class, 'publish'])
                ->middleware('permission:posts.publish')
                ->name('reviews.publish');

            Route::resource('categories', CategoryController::class)
                ->middleware('permission:categories.manage');

            Route::resource('tags', TagController::class)
                ->middleware('permission:tags.manage');
        });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes (Super Admin Only)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:Super Admin')
        ->group(function () {

            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('tags', TagController::class);

            // ✅ Settings Routes
            Route::resource('settings', SettingController::class);

            // Bulk update settings
            Route::put('settings-bulk-update', [SettingController::class, 'bulkUpdate'])
                ->name('settings.bulk-update');
        });
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';