<?php


use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;


Route::get('log-viewer', [LogViewerController::class, 'index'])
    ->middleware("can:view-logs");

Route::get('/', static function () {
    return view('welcome');
});


Route::get("login", static function(){
    return view("welcome");
})->name("login");



