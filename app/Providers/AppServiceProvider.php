<?php

namespace App\Providers;

use App\Submission;
use App\Observers\SubmissionObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Submission::observe(SubmissionObserver::class);

        Relation::morphMap([
            'url' => \App\Url::class,
            'snippet' => \App\Snippet::class,
            'file' => \App\File::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('slugger', function($app) {
            return new \Darkshare\Slugger();
        });
    }
}
