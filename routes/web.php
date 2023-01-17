<?php

use App\Http\Controllers\FirebaseController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Events\Message;
use App\Events\Registr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

Route::get('messages', [FirebaseController::class, 'LoadFriends']);
Route::get('/', function(){
    return view('registration');
});
Route::get('auth', function(){
    return view('auth');
});
Route::get('exit', function(){
    setcookie( "user_name", "", time()-60);
    setcookie( "state_r", "", time()-60);
    return view('auth');
});
Route::post('/send-message', function(Request $request){
event(
    new Message(
        $request->input('username'),
        $request->input('message')
    )
);
return["success"=>true];
});
Route::post('auth2', [FirebaseController::class, 'RegistrationNewUser'])->name('firebase.index');
Route::post('auth1', [FirebaseController::class, 'Autorization'])->name('firebase1.index');
Route::post('friend_message', [FirebaseController::class, 'LoadMessages'])->name('firebase1.index');

