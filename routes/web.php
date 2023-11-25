<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPgController;
use Illuminate\Support\Facades\Broadcast;
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

Broadcast::routes(['middleware' => ['auth']]);  // Add this line inside the Route group


Route::get('conn', function () {
    return view('conn');
});

Route::post('/broadcasting/auth', function () {
    return auth()->check() ? auth()->user() : abort(403);
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
Route::get('/room/{roomId}', 'App\Http\Controllers\RoomController@displayRoom');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/add-pg', 'App\Http\Controllers\PGController@create')->name('addPg');
    Route::post('/add-pg', 'App\Http\Controllers\PGController@store');
    Route::get('/user/pgs', 'App\Http\Controllers\UserPgController@index')->name('myPgs');
    Route::get('/room/create/{pg_id}', 'App\Http\Controllers\RoomController@create');
    Route::post('/room/store/{pg_id}', 'App\Http\Controllers\RoomController@store');
    Route::get('/wishlist', 'App\Http\Controllers\RoomController@wishlist')->name('wishlist');
    Route::post('/wishlist/add/{room_id}', 'App\Http\Controllers\RoomController@addtoWishlist');
    Route::post('/wishlist/remove/{room_id}', 'App\Http\Controllers\RoomController@removefromWishlist');
    Route::get('/pg/{pg_id}/rooms', 'App\Http\Controllers\RoomController@getRoomsByPG');
    Route::delete('/rooms/{room}', 'App\Http\Controllers\RoomController@destroy')->name('roomDelete');
    Route::get('/room/edit/{roomId}', 'App\Http\Controllers\RoomController@showRoomUpdate')->name('showRoomUpdate');
    Route::post('/room/update/{roomId}', 'App\Http\Controllers\RoomController@update')->name('roomUpdate');
    Route::delete('/pg/{pg}', 'App\Http\Controllers\PGController@destroy')->name('pgDelete');
    Route::get('/pg/edit/{pgId}', 'App\Http\Controllers\PGController@showPgUpdate')->name('showPgUpdate');
    Route::post('/pg/update/{pgId}', 'App\Http\Controllers\PGController@update')->name('pgUpdate');
    

    Route::get('/conversations/{recipientId}/{pgId}', 'App\Http\Controllers\ChatController@showConversation')->name('allChats');
    Route::post('/send/{recipientId}/{pgId}', 'App\Http\Controllers\ChatController@sendMessage')->name('conversation');
    

    Route::get('/generate-token', function () {
        $user = Auth::user();
        $token = $user->createToken('Token')->accessToken;
        
        return response()->json(['access_token' => $token]);
    });

});








?>