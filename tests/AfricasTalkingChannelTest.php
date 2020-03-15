<?php

namespace NotificationChannels\AfricasTalking\Test;

use Mockery;
use Illuminate\Notifications\Notification;
use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;
use NotificationChannels\AfricasTalking\Exceptions\CouldNotSendNotification;

class AfricasTalkingChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $at;

    /** @var \NotificationChannels\Twitter\AfricasTalkingChannel */
    protected $channel;

    public function setUp(): void
    {
        parent::setUp();
        $this->at = Mockery::mock(AfricasTalkingSDK::class);
        $this->channel = new AfricasTalkingChannel($this->at);
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(AfricasTalkingSDK::class, $this->at);
        $this->assertInstanceOf(AfricasTalkingChannel::class, $this->channel);
    }

    /** @test */
    public function it_can_send_sms_notification()
    {
        $this->at->shouldReceive('send')
            ->once()
            ->andReturn(200);

        $this->channel->send(new TestNotifiable, new TestNotification);
    }

}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return string
     */
    public function routeNotificationForAfricasTalking()
    {
        return "+2341111111111";
    }
}


class TestNotification extends Notification
{
    /**
     * @param $notifiable
     * @return AfricasTalkingMessage
     * @throws CouldNotSendNotification
     */
    public function toAfricasTalking($notifiable)
    {
        return new AfricasTalkingMessage();
    }
}
