<?php

namespace NotificationChannels\AfricasTalking;

class AfricasTalkingMessage
{
    /** @var string */
    protected string $content = '';

    /** @var string|null */
    protected ?string $from;

    /** @var string|null */
    protected ?string $to;

    /**
     * Set content for this message.
     *
     * @param  string  $content
     * @return $this
     */
    public function content(string $content): self
    {
        $this->content = trim($content);

        return $this;
    }

    /**
     * Set sender for this message.
     *
     * @param  string  $from
     * @return self
     */
    public function from(string $from): self
    {
        $this->from = trim($from);

        return $this;
    }

    /**
     * Set recipient for this message.
     *
     * @param string $to
     * @return self
     */
    public function to(string $to): self
    {
        $this->to = trim($to);

        return $this;
    }

    /**
     * Get message content.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Get sender info.
     *
     * @return string|null
     */
    public function getSender(): ?string
    {
        return $this->from ?? config('services.africastalking.from');
    }

    /**
     * Get recipient info.
     *
     * @return string|null
     */
    public function getTo(): ?string
    {
        return $this->to ?? null;
    }
}
