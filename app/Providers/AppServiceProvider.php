<?php

namespace App\Providers;

use App\Repositories\Eloquent\EloquentQuestionsRepository;
use App\Repositories\QuestionsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QuestionsRepository::class, EloquentQuestionsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
