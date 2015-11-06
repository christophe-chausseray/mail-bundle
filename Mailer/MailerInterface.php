<?php

namespace Chris\Bundle\MailBundle\Mailer;

interface MailerInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array  $options
     */
    public function send($from, $to, $subject, $body, array $options);
}
