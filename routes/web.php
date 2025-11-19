<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UbigeoController;
use App\Http\Controllers\AIAssistantSettingsController;

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
Route::get('/', [LoginController::class, 'view'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [ChatController::class, 'index']);
    Route::get('/messages/{user}', [ChatController::class, 'fetchMessages']);
    Route::post('/messages', [ChatController::class, 'send']);

    Route::get('/map', [MapController::class, 'index']);

    Route::resource('advisors', AdvisorController::class)->names([
        'index' => 'admin.advisors',
        'store' => 'admin.advisors.store',
        'create' => 'admin.advisors.create',
        'update' => 'admin.advisors.update',
        'edit' => 'admin.advisors.edit',
        'destroy' => 'admin.advisors.destroy',
        'show' => 'admin.advisors.show',
    ]);

    Route::get('/ubigeo/departments/', [UbigeoController::class, 'departments'])->name('ubigeo.departments');
    Route::get('/ubigeo/provinces/{department}', [UbigeoController::class, 'provinces'])->name('ubigeo.provinces');
    Route::get('/ubigeo/districts/{province}', [UbigeoController::class, 'districts'])->name('ubigeo.districts');

     Route::get('/ai-assistant', [AIAssistantSettingsController::class, 'index'])
        ->name('admin.ai_assistant_settings');

    Route::post('/ai-assistant', [AIAssistantSettingsController::class, 'update'])
        ->name('admin.ai_assistant_settings.update');

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::post('/logout', [LoginController::class, 'logout']);
});
