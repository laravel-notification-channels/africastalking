<?php

use NotificationChannels\AfricasTalking\AfricasTalkingMessage;

beforeEach(function () {
    $this->message = new AfricasTalkingMessage();
    config(['services.africastalking.from' => 'AFRICASTKNG']);
});

it('can get the content', function () {
    $this->message->content('myMessage');
    expect($this->message->getContent())->toEqual('myMessage');
});

it('can get the sender', function () {
    $this->message->from('YOURSHORTCODE');
    expect($this->message->getSender())->toEqual('YOURSHORTCODE');
});

it('can get the default sender', function () {
    expect($this->message->getSender())->toEqual('AFRICASTKNG');
});
