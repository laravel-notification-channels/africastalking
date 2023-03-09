<?php

namespace NotificationChannels\AfricasTalking\Test;

use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use AfricasTalking\SDK\SMS;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;
use NotificationChannels\AfricasTalking\Exceptions\CouldNotSendNotification;

class AfricasTalkingChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $africasTalking;

    /** @var \NotificationChannels\AfricasTalking\AfricasTalkingChannel */
    protected $channel;

    public function setUp(): void
    {
        parent::setUp();
        $this->africasTalking = Mockery::mock(AfricasTalkingSDK::class);
        $this->sms = Mockery::mock(SMS::class);
        $this->channel = new AfricasTalkingChannel($this->africasTalking);
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(AfricasTalkingSDK::class, $this->africasTalking);
        $this->assertInstanceOf(AfricasTalkingChannel::class, $this->channel);
    }

    /** @test */
    public function it_can_send_sms_notification_to_notifiable_with_method()
    {
        $this->africasTalking->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send(new NotifiableWithMethod, new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_anonymous_notifiable_using_class_name()
    {
        $this->africasTalking->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send((new AnonymousNotifiable())->route(AfricasTalkingChannel::class, '+1111111111'), new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_anonymous_notifiable_using_string_name()
    {
        $this->africasTalking->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send((new AnonymousNotifiable())->route('africasTalking', '+1111111111'), new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_notifiable_with_attribute()
    {
        $this->africasTalking->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send(new NotifiableWithAttribute(), new TestNotification);
    }

    /** @test */
    public function it_can_send_sms_notification_to_message_get_to()
    {
        $this->africasTalking->expects('sms')
            ->once()
            ->andReturn($this->sms);

        $this->sms->expects('send')
            ->once()
            ->andReturn(200);

        $this->channel->send(new AnonymousNotifiable(), new TestNotificationWithGetTo);
    }
}

class NotifiableWithMethod
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return string
     */
    public function routeNotificationForAfricasTalking()
    {
        return '+2341111111111';
    }
}

class TestNotification extends Notification
{
    /**
     * @param $notifiable
     * @return AfricasTalkingMessage
     * @throws CouldNotSendNotification
     *
     */
    public function toAfricasTalking($notifiable)
    {
        return new AfricasTalkingMessage();
    }
}

class TestNotificationWithGetTo extends Notification
{
    /**
     * @param $notifiable
     * @return AfricasTalkingMessage
     * @throws CouldNotSendNotification
     *
     */
    public function toAfricasTalking($notifiable)
    {
        return (new AfricasTalkingMessage())
            ->to('+22222222222');
    }
}

class Notifiable
{
    public $phone_number = null;

    public function routeNotificationFor()
    {
    }
}

class NotifiableWithAttribute
{
    public $phone_number = '+22222222222';

    public function routeNotificationFor()
    {
    }
}
