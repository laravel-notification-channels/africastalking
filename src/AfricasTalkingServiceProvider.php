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
        /**
         * Bootstrap the application services.
         */
        $this->app->when(AfricasTalkingChannel::class)
            ->needs(AfricasTalkingSDK::class)
            ->give(function () {
                $userName = config('services.africastalking.username');
                $key = config('services.africastalking.key');
                if (is_null($userName) || is_null($key)) {
                    throw InvalidConfiguration::configurationNotSet();
                }
                $at =  new AfricasTalkingSDK(
                    $userName,
                    $key
                );
                
                return $at->sms();
            });
    }
}
