<?php

use App\Http\Controllers\Api\ArticleApiController;
use Illuminate\Support\Facades\Route;


Route::get('/', static function () {
    return view('welcome');
});


Route::get("login", static function(){
    return view("welcome");
})->name("login");



