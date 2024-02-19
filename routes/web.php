<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
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
Route::post('/friends', [UserController::class, 'deletingFromFriends'])->name('friends');


Route::post('/usersFriends', [UserController::class, 'getFormUsersFriends'])->name('usersFriends');
Route::post('/friends', [UserController::class, 'postTheUsersHomePage'])->name('friends');

Route::get('/updateUser', [UserController::class, 'getFormUpdateUser'])->name('updateUser');
Route::post('/updateUser', [UserController::class, 'updateUser']);

Route::get('/allUser', [UserController::class, 'getFormUsers'])->name('user');
Route::post('/allUser', [UserController::class, 'addFriend'])->name('user');

Route::get('/mainUser', [UserController::class, 'getTheUsersHomePage'])->name('mainUser');
Route::post('/mainUser', [UserController::class, 'postUsersFriends']);
Route::post('/allUser', [UserController::class, 'postTheUsersHomePage'])->name('user');


Route::get('/messages', [UserController::class, 'getFormMessages'])->name('messages');
Route::post('/mainUser', [UserController::class, 'postMessages']);
Route::post('/messages', [UserController::class, 'creatMessages'])->name('messages');



Route::get('/post', [PostController::class, 'getPosts'])->name('post');
Route::post('/post', [PostController::class, 'likePosts'])->name('post');

Route::get('/creatPost', [PostController::class, 'getFormCreatPost'])->name('creatPost');
Route::post('/creatPost', [PostController::class, 'creatPost']);
Route::post('/main', [PostController::class, 'deletePost']);

Route::post('/main', [PostController::class, 'updatePost']);




