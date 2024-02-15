<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RegistrateController;
use App\Http\Controllers\UserController;
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


Route::get('/', function () {
    return view('app');
});

Route::get('/main', [MainController::class, 'getForm'])->name('main');
//Route::post('/main', [MainController::class, 'post']);

Route::get('/registrate', [UserController::class, 'getFormRegistrate'])->name('registrate');
Route::post('/registrate', [UserController::class, 'postRegistrate']);

Route::get('/login', [UserController::class, 'getFormLogin'])->name('login');
Route::post('/login', [UserController::class, 'postLogin']);

Route::get('/friends', [UserController::class, 'friends'])->name('friends');
Route::post('/friends', [UserController::class, 'deletingFromFriends']);

Route::get('/post', [UserController::class, 'getPosts'])->name('post');
Route::post('/post', [UserController::class, 'likePosts'])->name('post');


Route::get('/creatPost', [UserController::class, 'getFormCreatPost'])->name('creatPost');
Route::post('/creatPost', [UserController::class, 'creatPost']);

Route::get('/updateUser', [UserController::class, 'getFormUpdateUser'])->name('updateUser');
Route::post('/updateUser', [UserController::class, 'updateUser']);

Route::get('/user', [UserController::class, 'getFormUsers'])->name('user');
Route::post('/user', [UserController::class, 'addFriend'])->name('user');

