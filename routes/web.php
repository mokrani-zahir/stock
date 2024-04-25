<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\MouvementController;
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

Route::get('/', function () {
    return view('index');
});

Route::get('/test',[TestController::class,'index'])->name('index');
Route::get('/bon',[TestController::class,'bon'])->name('bon');
Route::post('/request',[TestController::class,'request']);
Route::get('/mouvement',[MouvementController::class,'index'])->name('mouvement');
// Route::post('/search',[TestController::class,'searchF']);


// https://laravel.com/docs/11.x/routing#route-group-prefixes
Route::prefix('/search')->group(function(){
    Route::post('/fournisseur',[TestController::class,'searchF']);
    Route::post('/article',[TestController::class,'searchA']);
});
