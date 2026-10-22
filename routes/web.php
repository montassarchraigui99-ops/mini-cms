<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/bienvenue', function () {
    return 'Bienvenue sur Mini-CMS';
});
Route::get('/heure', [PageController::class, 'time'])->name('time');

Route::get('/posts/archive/{year}', [PostController::class, 'archive'])
    ->whereNumber('year')
    ->name('posts.archive');

Route::resource('posts', PostController::class)->only(['index', 'show', 'create', 'store']);

Route::get('/a-propos', function () {
    return view('a-propos', [
        'auteur' => 'Montassar Chraigui',
        'groupe' => 'MDW32',
    ]);
});