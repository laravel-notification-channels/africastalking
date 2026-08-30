<?php

namespace NotificationChannels\AfricasTalking\Test;

use NotificationChannels\AfricasTalking\AfricasTalkingMessage;
use PHPUnit\Framework\Attributes\Test;

class AfricasTalkingMessageTest extends TestCase
{
    /** @var AfricasTalkingMessage */
    protected $message;

    public function setUp(): void
    {
        parent::setUp();
        $this->message = new AfricasTalkingMessage();
        config(['services.africastalking.from' => 'AFRICASTKNG']);
    }

    #[Test]
    public function it_can_get_the_content()
    {
        $this->message->content('myMessage');
        $this->assertEquals('myMessage', $this->message->getContent());
    }

    #[Test]
    public function it_can_get_the_sender()
    {
        $this->message->from('YOURSHORTCODE');
        $this->assertEquals('YOURSHORTCODE', $this->message->getSender());
    }

    #[Test]
    public function it_can_get_the_default_sender()
    {
        $this->assertEquals('AFRICASTKNG', $this->message->getSender());
    }
}
