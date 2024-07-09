<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:sanctum','isAPIAdmin')->group(function(){//ensure that only authenticated users can access it.This groups routes that require the auth:sanctum middleware. It means any route within this group will require the user to be authenticated using Laravel Sanctum.
    Route::get('/checkingAuthenticated',function(){
        return response()->json(['message'=> 'You are in','status'=>200],200);
    });
});


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
});


Route::get('/showuser',[AuthController::class,'show']);// This route shows user information// Accessible without authentication
Route::post('/register',[AuthController::class,'register']); //kernel.php,cors.php,User.php,AuthController
Route::post('/login',[AuthController::class,'login']);





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
