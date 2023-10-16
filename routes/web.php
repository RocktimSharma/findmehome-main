<?php

use App\Http\Controllers\AuthManager;
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



Route::get('conn', function () {
    return view('conn');
});


  
/*Route::get('/registration1', function () {
    return view('registration1'); 
});*/

//Route::get('/registration1', 'App\Http\Controllers\AuthManager@registration1');
Route::get('/login1', [AuthManager::class, 'login1'])->name('login1');
Route::post('/login1', [AuthManager::class, 'login1Post'])->name('login1.post');
Route::get('/registration1', [AuthManager::class, 'registration1'])->name('registration1');
Route::post('/registration1', [AuthManager::class, 'registration1Post'])->name('registration1.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

Route::get('register-owner', function () {
    return view('registerowner');
});


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/add-pg', 'App\Http\Controllers\PGController@create');
Route::post('/add-pg', 'App\Http\Controllers\PGController@store');


?>