<?php

namespace NotificationChannels\AfricasTalking;

use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use Exception;
use Illuminate\Notifications\Notification;
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
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toAfricasTalking($notifiable);

        if (! $phoneNumber = $notifiable->routeNotificationFor('africasTalking')) {
            $phoneNumber = $notifiable->phone_number;
        }

        try {
            $this->africasTalking->sms()->send([
                'to'      => $phoneNumber,
                'message' => $message->getContent(),
                'from'    => $message->getSender(),
            ]);
        } catch (Exception $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
}
