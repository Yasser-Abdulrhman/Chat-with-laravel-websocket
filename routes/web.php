<?php

use Illuminate\Support\Facades\Route;
use App\Events\WebSocketDemoEvent;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatController;

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
   broadcast(new WebSocketDemoEvent('some data'));
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth','verified']], function () {
    Route::get('/chat' , [ChatController::class , 'index']);
    Route::get('/messages' , [ChatController::class , 'fetchMessages']);
    Route::post('/messages' , [ChatController::class , 'sendMessage']);
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
