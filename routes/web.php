<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RegistrateController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/registrate', [RegistrateController::class, 'getForm'])->name('registrate');
Route::post('/registrate', [RegistrateController::class, 'postRegistrate']);

Route::get('/login', [LoginController::class, 'getForm'])->name('login');
Route::post('/login', [LoginController::class, 'postLogin']);

Route::get('/main', [MainController::class, 'getForm'])->name('main');
//Route::post('/login', [LoginController::class, 'postLogin']);
