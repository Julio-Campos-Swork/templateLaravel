<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/auth/logout', [UserController::class, 'logout']);
Route::post('/auth/register', [UserController::class, 'create']);
Route::middleware('auth:sanctum')->group(function (){
// administrado de usuarios
    Route::get('admin/getUserList', [UserController::class, 'getUserList']);
    Route::post('admin/updateUserInfo', [UserController::class, 'updateUserInfo']);
    Route::post('admin/updateUserPassword', [UserController::class, 'updateUserPassword']);
});
