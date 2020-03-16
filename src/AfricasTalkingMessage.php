<?php

namespace NotificationChannels\AfricasTalking;

class AfricasTalkingMessage
{
    /** @var string */
    protected $content;

    /** @var string|null */
    protected $from;

    /**
     * Set the content for this message
     * 
     * 
     * @param string $content
     * @return this
     */
    public function content(string $content) :self
    {
        $this->content = trim($content);

        return $this;
    }

    /**
     * Set the sender for this message
     * 
     * @param string $from
     * @return this
     */
    public function from(string $from) :self
    {
        $this->from = trim($from);

        return $this;
    }

    /**
     * Get Message Content
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get Sender Info
     * 
     * @return string
     */
    public function getSender()
    {
        return $this->from ?? config("services.africastalking.from");
    }
}
