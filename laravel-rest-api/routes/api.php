<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountiesController;

Route::get('/counties', [CountiesController::class, 'index']);
Route::post('/counties', [CountiesController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/counties/{id}', [CountiesController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/counties/{id}', [CountiesController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/users/login', [UsersController::class, 'login']);
Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');

