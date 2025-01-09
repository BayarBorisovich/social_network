<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', function () {
        return view('verify-email');
    })->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('main');
    })->name('verification.verify')->middleware(['signed']);
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->name('verification.send')->middleware(['throttle:6,1']);

    Route::group(['prefix' => 'main'], function () {
        Route::get('/', [MainController::class, 'showMainPaigeForm'])->name('main');
        Route::get('/weather', [MainController::class, 'getWeather']);
    });

    Route::middleware('verified')->group(function () {

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileController::class, 'showProfileForm'])->name('profile');
            Route::post('/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
            Route::post('/information', [ProfileController::class, 'updateOrCreateInformation'])->name('profile.information.update');

        });

        Route::group(['prefix' => 'friends'], function () {
            Route::get('/showForm', [FriendController::class, 'showFormFriends'])->name('friends');
            Route::get('/', [FriendController::class, 'getFriends']);
            Route::post('/add/{userId}', [FriendController::class, 'addFriend']);
            Route::post('/delete{friendId}', [FriendController::class, 'deleteFriend']);
        });

        Route::group(['prefix' => 'message'], function () {
            Route::get('/{userId}', [MessageController::class, 'getMessages'])->name('messages');
            Route::post('/create/{id}', [MessageController::class, 'createMessages']);
        });

        Route::group(['prefix' => 'user-profile'], function () {
            Route::get('/{friendId}', [UserProfileController::class, 'getTheUsersHomePage'])->name('user-profile');
            Route::get('/friends/{userId}', [UserProfileController::class, 'getFormUsersFriends'])->name('user-profile.friends');
        });

        Route::group(['prefix' => 'comments'], function () {
            Route::post('/{postId}', [CommentController::class, 'creatComment'])->name('post.comment');
        });

        Route::get('/image', [ImageController::class, 'getImages'])->name('image');
        Route::post('/image', [ImageController::class, 'postImage']);

        Route::get('/photo', [ImageController::class, 'getPhoto'])->name('photo');

        Route::group(['prefix' => 'users'], function () {
            Route::get('/showForm', [UserController::class, 'showFormsUsers'])->name('user');
            Route::get('/', [UserController::class, 'getUsers']);
        });

        Route::group(['prefix' => 'posts'], function (){
            Route::get('/showCreate', [PostController::class, 'showCreatePosts'])->name('post.create');//->middleware('verified');
            Route::post('/create', [PostController::class, 'create']);
            Route::post('/delete/{post}', [PostController::class, 'delete'])->name('post.delete');
            Route::post('/update/{post}', [PostController::class, 'update'])->name('post.update');

            Route::get('/my-posts', [PostController::class, 'getMyPosts']);

            Route::get('/', [PostController::class, 'showFormFriendsPosts'])->name('post');
            Route::get('/friends', [PostController::class, 'getFriendsPosts']);

            Route::post('/like/{postId}', [PostController::class, 'likePosts'])->name('post.like');

        });

        Route::get('/mail',  [MailController::class, 'basic_email']);

    });
});



