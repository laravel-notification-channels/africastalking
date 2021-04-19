<?php

namespace NotificationChannels\AfricasTalking;

use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\AfricasTalking\Exceptions\InvalidConfiguration;

class AfricasTalkingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/africastalking.php' => config_path('africastalking.php'),
            ], 'config');
        }

        /**
         * Bootstrap the application services.
         */
        $this->app->when(AfricasTalkingChannel::class)
            ->needs(AfricasTalkingSDK::class)
            ->give(function () {
                $username = config('africastalking.username');
                $key = config('africastalking.key');

                if (is_null($username) || is_null($key)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new AfricasTalkingSDK($username, $key);
            });
    }


    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/africastalking.php', 'africastalking');
    }
}
