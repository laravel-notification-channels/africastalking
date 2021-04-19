<?php

namespace NotificationChannels\AfricasTalking;

class AfricasTalkingMessage
{
    /** @var string */
    protected $content;

    /** @var string|null */
    protected $from;

    /**
     * Set content for this message.
     */
    public function content(string $content): self
    {
        $this->content = trim($content);

        return $this;
    }

    /**
     * Set sender for this message.
     */
    public function from(string $from): self
    {
        $this->from = trim($from);

        return $this;
    }

    /**
     * Get message content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get sender info.
     *
     * @return string
     */
    public function getSender()
    {
        return $this->from ?? config('africastalking.from');
    }
}
