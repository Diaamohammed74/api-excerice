<?php

use App\Http\Controllers\Api\AdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;

Route::controller(UserController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth:sanctum');
});

Route::get('/cities',CityController::class);
Route::get('/districts',DistrictController::class);

Route::prefix('messages')->controller(MessageController::class)->group(function(){
    Route::get('/','index');
    Route::get('search','search');
});
Route::prefix('ads')->controller(AdController::class)->group(function(){
        Route::get('/','index');
        Route::get('search','search');
        Route::middleware('auth:sanctum')->group(function(){
            Route::post('create','create');
            Route::post('update/{ad_id}','update');
            Route::get('delete/{ad_id}','delete');
            Route::get('myads','myAds');
        });
});


