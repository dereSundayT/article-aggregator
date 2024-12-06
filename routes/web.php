<?php

use App\Http\Controllers\Api\ArticleApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("login", static function(){
    return view("welcome");
})->name("login");


Route::get('test',[ArticleApiController::class,'test']);
