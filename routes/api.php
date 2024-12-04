<?php

use App\Http\Controllers\Api\AuthenticationApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(static function () {
    //::: Authentication routes
    Route::group(['prefix' => 'auth'], static function () {
        Route::post('/register', [AuthenticationApiController::class,'register']);
        Route::post('/login', [AuthenticationApiController::class,'login']);
    });






    Route::get('/user', static function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

