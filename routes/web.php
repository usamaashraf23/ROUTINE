<?php

use App\Events\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

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
Route::get('/', [UserController::class,"showCorrectHomepage"])->name('login');
Route::post('/register',[UserController::class,"register"])->middleware('guest');
Route::post('/login',[UserController::class,'login'])->middleware('guest');
Route::post('/logout',[UserController::class,'logout'])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar',[UserController::class,'showAvatarForm'])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar',[UserController::class,'storeAvatar'])->middleware('mustBeLoggedIn');

//blog related routes
Route::get('/create-post',[PostController::class,'createPost'])->middleware('mustBeLoggedIn');
Route::post('/create-post',[PostController::class,'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{post}',[PostController::class,'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class,'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class,'actuallyUpdate'])->middleware('can:update,post');
Route::get('/search{term}',[PostController::class,'search']);
//follow related routes
Route::post('/create-follow/{user:username}',[FollowController::class,'createFollow'])->middleware('can:update,post');
Route::post('/remove-follow/{user:username}',[FollowController::class,'removeFollow'])->middleware('can:update,post');

//profile relate routes
Route::get('/profile/{user:username}',[UserController::class,'profile']);
Route::get('/profile/{profile:username/followers}',[UserController::class,'profileFollowers']);
Route::get('/profile/{profile:username/following}',[UserController::class,'profileFollowing']);

//chat related routes
Route::post('/send-chat-message',function(Request $request){
    $formFields=$request->validate([
        'textvalue'=>'required'
    ]);
    if(!trim(strip_tags($formFields['textvalue']))){
        return response()->noContent();
    }
    broadcast(new ChatMessage(['username'=>auth()->user()->username,'textvalue'=>strip_tags($request->textvalue)]))->toOthers();
    return response()->noContent();

})->middleware('mustBeLoggedIn');