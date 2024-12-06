<?php

namespace App\Providers;

use App\Http\Service\Article\TheGuardianService;
use App\Http\Service\Article\TheNewsApiService;
use App\Http\Service\Article\TheNewYorkTimeService;
use App\Interfaces\IArticleSource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register IArticleSource implementations
//        $this->app->bind(IArticleSource::class, function () {
//            return [
//                new TheGuardianService(),
////                new TheNewsApiService(),
////                new TheNewYorkTimeService(),
//            ];
//        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
