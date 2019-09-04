<?php

namespace HarryGulliford\SocialiteMicrosoftGraph;

use Illuminate\Support\ServiceProvider;

class SocialiteMicrosoftGraphServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend('microsoft-graph', function ($app) use ($socialite) {
            $config = $app['config']['services.microsoft-graph'];

            return $socialite->buildProvider(MicrosoftGraphProvider::class, $config);
        });
    }
}
