<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;

Route::get('/cities',CityController::class);
Route::get('/districts',DistrictController::class);



