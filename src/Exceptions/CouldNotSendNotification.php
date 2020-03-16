<?php

namespace NotificationChannels\AfricasTalking\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * @param string $error
     * @return CouldNotSendNotification
     */
    public static function serviceRespondedWithAnError(string $error): self
    {
        return new static("AfricasTalking service responded with an error: {$error}");
    }
}
