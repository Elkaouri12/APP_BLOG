<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FavorieController;
use App\Http\Controllers\Api\CategoryController;
// use App\Http\Controllers\CategoryController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});


Route::group([ 'middleware'=>['auth:sanctum']  ],function(){
    Route::get('logout',[AuthController::class,'logout']);
    Route::get('profile',[AuthController::class,'Profile']);
    Route::put('update/{id}',[AuthController::class,'update']);
    Route::get('/users', [AuthController::class, 'index']);
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);

});
// -------------------------------Category Routes--------------------------------
Route::resource('category',CategoryController::class);
// -------------------------------Post Routes--------------------------------
Route::resource('post',PostController::class);
// -------------------------------Favorite Routes--------------------------------
Route::resource('favorite',FavorieController::class);
// -------------------------------comment Routes--------------------------------
Route::resource('comment',CommentController::class);
// -------------------------------Rating Routes--------------------------------
Route::resource('rating',RatingController::class);


Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('forget',[AuthController::class,'forget']);
Route::post('reset',[AuthController::class,'reset']);


 
 