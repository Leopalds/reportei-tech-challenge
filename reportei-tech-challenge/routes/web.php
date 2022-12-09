<?php

use App\Http\Controllers\auth\GithubAuthController;
use App\Http\Controllers\RepositoryController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/auth/redirect', function (){
    return Socialite::driver('github')->redirect();
})->name('auth.github');

Route::get('/auth/callback', [GithubAuthController::class, 'callback'])->name('auth.callback');

Route::get('/teste', [RepositoryController::class, 'teste'])->name('teste')->middleware(['auth']);

require __DIR__.'/auth.php';
