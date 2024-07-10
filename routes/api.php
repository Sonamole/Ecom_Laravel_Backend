<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;
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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register',[AuthController::class,'register']); //kernel.php,cors.php,User.php,AuthController
Route::post('/login',[AuthController::class,'login']);


Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function(){//ensure that only authenticated users can access it.This groups routes that require the auth:sanctum middleware. It means any route within this group will require the user to be authenticated using Laravel Sanctum.
    Route::get('/checkingAuthenticated',function(){
        return response()->json(['message'=> 'You are in','status'=>200],200);
    });

    //category section
    Route::get('/view-category',[CategoryController::class,'index']);
    Route::post('/store-category',[CategoryController::class,'store']);
    Route::get('/edit-category/{id}',[CategoryController::class,'edit']);
    Route::put('/update-category/{id}',[CategoryController::class,'update']);
    Route::delete('/delete-category/{id}',[CategoryController::class,'destroy']);
});


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
});








