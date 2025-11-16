<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MapController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [ChatController::class, 'index']);
Route::get('/messages/{user}', [ChatController::class, 'fetchMessages']);
Route::post('/messages', [ChatController::class, 'send']);


Route::get('/map', [MapController::class, 'index']);
