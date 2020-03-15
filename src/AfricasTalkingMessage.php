<?php

namespace NotificationChannels\AfricasTalking;

class AfricasTalkingMessage
{
    /** @var string */
    protected $content;

    /** @var string */
    protected $from = null;

    /**
     * Set the content for this message
     * 
     * 
     * @param string $content
     * @return this
     */
    public function content(string $content)
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
    public function from(string $from)
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