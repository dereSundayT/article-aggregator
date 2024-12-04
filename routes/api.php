<?php

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\AuthenticationApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(static function () {
    //::: Authentication routes
    Route::group(['prefix' => 'auth'], static function () {
        Route::post('/register', [AuthenticationApiController::class,'register']);
        Route::post('/login', [AuthenticationApiController::class,'login']);
    });

    //::: Protected routes
    Route::middleware('auth:sanctum')->group(static function () {

        //::: User preference routes
        Route::group(['prefix' => 'user'], static function () {
            Route::get('/preference', [UserApiController::class,'getUserSettings']);
            Route::patch('/preference', [UserApiController::class,'updateUserPreference']);
        });

        //::: Article routes
        Route::group(['prefix' => 'article'], static function () {
            Route::get('', [ArticleApiController::class,'getArticles']);
        });

    });






    Route::get('/user', static function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

