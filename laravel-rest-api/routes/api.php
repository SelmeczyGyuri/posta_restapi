<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CountiesController;
use App\Http\Controllers\CitiesController;

Route::get('/cities', [CitiesController::class, 'index']);
Route::get('/cities/{id}', [CitiesController::class, 'show']);
Route::post('/cities', [CitiesController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/cities/{id}', [CitiesController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/cities/{id}', [CitiesController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/counties', [CountiesController::class, 'index']);
Route::get('/counties/{id}', [CountiesController::class, 'show']);
Route::post('/counties', [CountiesController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/counties/{id}', [CountiesController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/counties/{id}', [CountiesController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/users/login', [UsersController::class, 'login']);
Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');

