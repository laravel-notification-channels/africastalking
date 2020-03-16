<?php

namespace NotificationChannels\AfricasTalking\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet(): self
    {
        return new static('To send notifications via AfricasTalking you need to add credentials in the `africastalking` key of `config.services`.');
    }
}
