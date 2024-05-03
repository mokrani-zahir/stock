<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\BonController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\AuthController;
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

//->middleware('auth');

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/bon',[BonController::class,'create'])->name('bon');
    Route::post('/bon',[BonController::class,'store']);
    Route::get('/mouvement',[MouvementController::class,'index'])->name('mouvement');
    Route::get('/logout',[AuthController::class,'logout']);
});

Route::get('/test',[TestController::class,'index'])->name('index');

Route::get('/login',[AuthController::class,'index'])->name('login');
Route::post('/login',[AuthController::class,'login']);
// Route::post('/search',[TestController::class,'searchF']);


// https://laravel.com/docs/11.x/routing#route-group-prefixes
Route::prefix('/search')->group(function(){
    Route::post('/fournisseur',[TestController::class,'searchF']);
    Route::post('/article',[TestController::class,'searchA']);
});
