<?php

namespace NotificationChannels\AfricasTalking;

use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\AfricasTalking\Exceptions\CouldNotSendNotification;

class AfricasTalkingChannel
{
    /** @var AfricasTalkingSDK */
    protected $at;

    /** @param TwitterOAuth $twitter */
    public function __construct(AfricasTalkingSDK $at)
    {
        $this->at = $at;
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
        $driver = $notifiable->routeNotificationFor('AfricasTalking');
        
        $phoneNumber = $driver
                ? $driver 
                : $notifiable->phone_number;

        try{
           $this->at->send([
            "to" => $phoneNumber,
            "message" => $message->getContent(),
            "from" => $message->getSender() ]);
        } catch(Exception $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
      
}
