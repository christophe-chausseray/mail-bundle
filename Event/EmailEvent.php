<?php

namespace Chris\Bundle\MailBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Alexlbr\EmailLibrary\Email;

class EmailEvent extends Event
{
    /**
     * @var Email $email
     */
    protected $email;

    /**
     * @var bool $isCanceled
     */
    protected $isCanceled;

    /**
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->email      = $email;
        $this->isCanceled = false;
    }

    /**
     * @return Email
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
