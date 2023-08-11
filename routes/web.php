<?php

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

Route::get('/', [\App\Http\Controllers\TestController::class, 'test1']);
Route::get('/test1', [\App\Http\Controllers\TestController::class, 'test1']);
Route::get('/test2', [\App\Http\Controllers\TestController::class, 'test2']);
Route::get('/test3', [\App\Http\Controllers\TestController::class, 'test3']);
Route::post('/export_csv', [\App\Http\Controllers\TestController::class, 'exportCsv'])->name('export_csv');

