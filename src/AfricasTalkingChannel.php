<?php

namespace NotificationChannels\AfricasTalking;

use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use Exception;
use Illuminate\Notifications\Notification;
use NotificationChannels\AfricasTalking\Exceptions\CouldNotSendNotification;
use NotificationChannels\AfricasTalking\Exceptions\InvalidPhonenumber;

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
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toAfricasTalking($notifiable);

        $phoneNumber = $this->getTo($notifiable, $notification, $message);

        if (empty($phoneNumber)) {
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

    private function getTo($notifiable, Notification $notification, AfricasTalkingMessage $message)
    {
        if (! empty($message->getTo())) {
            return $message->getTo();
        }

        if ($notifiable->routeNotificationFor(static::class, $notification)) {
            return $notifiable->routeNotificationFor(static::class, $notification);
        }

        if ($notifiable->routeNotificationFor('africasTalking', $notification)) {
            return $notifiable->routeNotificationFor('africasTalking', $notification);
        }

        if (isset($notifiable->phone_number)) {
            return $notifiable->phone_number;
        }

        throw CouldNotSendNotification::invalidReceiver();
    }
}
