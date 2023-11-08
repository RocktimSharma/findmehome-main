<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPgController;

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
#Route::get('/login', [AuthManager::class, 'login'])->name('login');
#Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
#Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

Route::get('register-owner', function () {
    return view('registerowner');
});


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/search-pgs', 'App\Http\Controllers\PGController@search');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/add-pg', 'App\Http\Controllers\PGController@create')->name('addPg');
    Route::post('/add-pg', 'App\Http\Controllers\PGController@store');
    Route::get('/user/pgs', 'App\Http\Controllers\UserPgController@index')->name('myPgs');
    Route::get('/room/create/{pg_id}', 'App\Http\Controllers\RoomController@create');
    Route::post('/room/store/{pg_id}', 'App\Http\Controllers\RoomController@store');
   
    Route::get('/pg/{pg_id}/rooms', 'App\Http\Controllers\RoomController@getRoomsByPG');
    Route::delete('/rooms/{room}', 'App\Http\Controllers\RoomController@destroy')->name('roomDelete');
    Route::delete('/pg/{pg}', 'App\Http\Controllers\PGController@destroy')->name('pgDelete');

    Route::get('/conversations/{recipientId}', 'App\Http\Controllers\ChatController@showConversation');
    Route::post('/conversations/{recipientId}', 'App\Http\Controllers\ChatController@sendMessage')->name('conversation');
    



});






?>