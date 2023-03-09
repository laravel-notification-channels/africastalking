<?php

namespace NotificationChannels\AfricasTalking\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * @param  string  $error
     * @return CouldNotSendNotification
     */
    public static function serviceRespondedWithAnError(string $error): self
    {
        return new static("AfricasTalking service responded with an error: {$error}");
    }

    public static function invalidReceiver(): self
    {
        return new static('The notifiable did not have a receiving phone number. Add a routeNotificationForAfricasTalking
            method or a phone_number attribute to your notifiable.');
    }
}
