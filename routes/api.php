<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\UserController;

Route::controller(UserController::class)->group(function(){
    Route::post('register','register');
});

Route::get('/cities',CityController::class);
Route::get('/districts',DistrictController::class);



