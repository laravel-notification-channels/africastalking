<?php

use AfricasTalking\SDK\AfricasTalking as AfricasTalkingSDK;
use AfricasTalking\SDK\SMS;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;
use NotificationChannels\AfricasTalking\Exceptions\CouldNotSendNotification;
use NotificationChannels\AfricasTalking\Test\TestCase;

beforeEach(function () {
    $this->africasTalking = Mockery::mock(AfricasTalkingSDK::class);
    $this->sms = Mockery::mock(SMS::class);
    $this->channel = new AfricasTalkingChannel($this->africasTalking);
});

it('can be instantiated', function () {
    expect($this->africasTalking)->toBeInstanceOf(AfricasTalkingSDK::class);
    expect($this->channel)->toBeInstanceOf(AfricasTalkingChannel::class);
});

it('can send sms notification to notifiable with method', function () {
    $this->africasTalking->expects('sms')->once()->andReturn($this->sms);
    $this->sms->expects('send')->once()->andReturn(200);

    $this->channel->send(new AfricasTalkingChannelTest, new TestNotification);
});

it('can send sms notification to anonymous notifiable using class name', function () {
    $this->africasTalking->expects('sms')->once()->andReturn($this->sms);
    $this->sms->expects('send')->once()->andReturn(200);

    $this->channel->send(
        (new AnonymousNotifiable())->route(AfricasTalkingChannel::class, '+1111111111'),
        new TestNotification
    );
});

it('can send sms notification to anonymous notifiable using string name', function () {
    $this->africasTalking->expects('sms')->once()->andReturn($this->sms);
    $this->sms->expects('send')->once()->andReturn(200);

    $this->channel->send(
        (new AnonymousNotifiable())->route('africasTalking', '+1111111111'),
        new TestNotification
    );
});

it('can send sms notification to notifiable with attribute', function () {
    $this->africasTalking->expects('sms')->once()->andReturn($this->sms);
    $this->sms->expects('send')->once()->andReturn(200);

    $this->channel->send(new NotifiableWithAttribute(), new TestNotification);
});

it('can send sms notification to message get to', function () {
    $this->africasTalking->expects('sms')->once()->andReturn($this->sms);
    $this->sms->expects('send')->once()->andReturn(200);

    $this->channel->send(new AnonymousNotifiable(), new TestNotificationWithGetTo);
});

class AfricasTalkingChannelTest
{
    use \Illuminate\Notifications\Notifiable;

    public function routeNotificationForAfricasTalking()
    {
        return '+2341111111111';
    }
}

class TestNotification extends Notification
{
    public function toAfricasTalking($notifiable)
    {
        return new AfricasTalkingMessage();
    }
}

class TestNotificationWithGetTo extends Notification
{
    public function toAfricasTalking($notifiable)
    {
        return (new AfricasTalkingMessage())->to('+22222222222');
    }
}

class NotifiableWithAttribute
{
    public $phone_number = '+22222222222';

    public function routeNotificationFor()
    {
    }
}
