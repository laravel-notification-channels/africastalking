<?php

namespace NotificationChannels\AfricasTalking;

use Exception;
use Illuminate\Notifications\Notification;
use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use NotificationChannels\AfricasTalking\Exceptions\InvalidPhonenumber;
use NotificationChannels\AfricasTalking\Exceptions\CouldNotSendNotification;

class AfricasTalkingChannel
{
    /** @var AfricasTalkingSDK */
    protected $africasTalking;

    /** @param AfricasTalkingSDK $africasTalking */
    public function __construct(AfricasTalkingSDK $africasTalking)
    {
        $this->africasTalking = $africasTalking;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toAfricasTalking($notifiable);

        if (!$phoneNumber = $notifiable->routeNotificationFor('africasTalking')) {
            $phoneNumber = $notifiable->phone_number ?? $message->getTo();
        }

        if(empty($phoneNumber)) {
            throw InvalidPhonenumber::configurationNotSet();
        }

        if (empty(($message->getSender())) || is_null($message->getSender())) {
            $params = [
                'to'        => $phoneNumber,
                'message'   => $message->getContent(),
            ];
        } else {
            $params = [
                    'to'        => $phoneNumber,
                    'message'   => $message->getContent(),
                    'from'      => $message->getSender(),
                ];
        }

        try {
            return $this->africasTalking->sms()->send($params);
        } catch (Exception $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
}
