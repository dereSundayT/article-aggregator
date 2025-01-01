<?php

namespace App\Providers;


use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Gate::define('check', static function (User $user, Article $article) {
//            return $user->id === $article->user_id;
//        });
    }
}
