<?php

namespace Chris\Bundle\MailBundle\Event;

use Alexlbr\EmailLibrary\EmailInterface;
use Symfony\Component\EventDispatcher\Event;

class EmailEvent extends Event
{
    /**
     * @var EmailInterface $email
     */
    protected $email;

    /**
     * @var bool $isCanceled
     */
    protected $isCanceled;

    /**
     * @param EmailInterface $email
     */
    public function __construct(EmailInterface $email)
    {
        $this->email      = $email;
        $this->isCanceled = false;
    }

    /**
     * @return EmailInterface
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get IsCanceled
     *
     * @return mixed
     */
    public function isCanceled()
    {
        return $this->isCanceled;
    }

    /**
     * Set IsCanceled
     *
     * @param mixed $isCanceled
     *
     * @return $this
     */
    public function setCanceled($isCanceled)
    {
        $this->isCanceled = $isCanceled;

        return $this;
    }
}
