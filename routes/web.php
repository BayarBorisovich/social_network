<?php

use App\Http\Controllers\ImageController;
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


//Route::get('/', function () {
//    return view('app');
//});

Route::get('/main', [MainController::class, 'getMain'])->name('main');
Route::post('/main', [PostController::class, 'likePosts']);

Route::get('/image', [ImageController::class, 'getImages'])->name('image');
Route::post('/image', [ImageController::class, 'postImage']);

Route::get('/photo', [ImageController::class, 'getPhoto'])->name('photo');

Route::get('/registrate', [UserController::class, 'getFormRegistrate'])->name('registrate');
Route::post('/registrate', [UserController::class, 'postRegistrate']);

Route::get('/login', [UserController::class, 'getFormLogin'])->name('login');
Route::post('/login', [UserController::class, 'postLogin']);

Route::get('/friends', [UserController::class, 'getFriends'])->name('friends');
Route::post('/friends', [UserController::class, 'deletingFromFriends']);

Route::get('/usersFriends/{userId}', [UserController::class, 'getFormUsersFriends'])->name('usersFriends');

Route::get('/updateUser', [UserController::class, 'getUpdateUser'])->name('updateUser');
Route::post('/updateUser', [UserController::class, 'updateUser']);

Route::get('/allUser', [UserController::class, 'getAllUsers'])->name('user');
Route::post('/allUser', [UserController::class, 'addFriend']);

Route::get('/mainUser/{friendId}', [UserController::class, 'getTheUsersHomePage'])->name('mainUser');

Route::get('/messages/{userId}', [UserController::class, 'getMessages'])->name('messages');
Route::post('/messages/create', [UserController::class, 'createMessages'])->name('messages.create');

Route::group(['prefix' => 'post'], function (){
    Route::get('/', [PostController::class, 'getPosts'])->name('post');
    Route::post('/like', [PostController::class, 'likePosts'])->name('post.like');
    Route::post('/comment', [PostController::class, 'creatComment'])->name('post.comment');
    Route::get('/create', [PostController::class, 'getCreatPost'])->name('post.create');
    Route::post('/create', [PostController::class, 'createPost'])->name('post.create');
    Route::post('/delete', [PostController::class, 'deletePost'])->name('post.delete');
    Route::post('/update', [PostController::class, 'updatePost'])->name('post.update');
});

Route::post('/logout', [PostController::class, 'logout'])->name('logout');




