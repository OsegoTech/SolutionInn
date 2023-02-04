<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Posts\PostsController;
use App\Http\Controllers\API\Users\UserController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//group v1
Route::group(['prefix'=>'v1'],function (){
    //group auth routes
    Route::group(['prefix'=>'auth'],function (){
        Route::post('register',[AuthController::class,'register']);
        Route::post('login',[AuthController::class,'login']);
    });
    //group protected routes
    Route::group(['middleware'=>'auth:sanctum'],function (){
//        Route::apiResource('users', UserController::class);
        //logout
        Route::get('auth/logout',[AuthController::class,'logout']);
        Route::get('users', [UserController::class,'index']);
        Route::get('users/{id}', [UserController::class,'show']);
        Route::patch('users/{id}', [UserController::class,'update']);
        Route::delete('users/{id}', [UserController::class,'destroy']);
    });

//    Posts Endpoints
    Route::post('/posts', [PostsController::class, 'store']);
    Route::get('/posts', [PostsController::class, 'index']);
    Route::get('/posts/{id}', [PostsController::class, 'show']);
    Route::patch('/posts/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);

//    Reviews Endpoints
    Route::get('/posts/{id}/reviews', [ReviewController::class, 'index']);
    Route::patch('/posts/{id}reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/posts/{id}/reviews/{id}', [ReviewController::class, 'destroy']);
    Route::post('/posts/{id}/reviews', [ReviewController::class, 'store']);

});
