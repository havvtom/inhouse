<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MessageController;
use App\Models\Notification;

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

Route::get('/', function (Request $request) {
    
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//messages routes
Route::group(['prefix' => 'messages' ], function (){
    Route::get('/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/', [MessageController::class, 'store'])->name('messages.store');
});


//Use the RoleMiddleware to anly allow users with role admin to acces the below routes
Route::group(['middleware' => 'role:admin' , 'prefix' => 'admin' ], function (){
    Route::get('notifications', function (){
        
    });
});
