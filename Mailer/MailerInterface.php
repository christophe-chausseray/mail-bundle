<?php

namespace Chris\Bundle\MailBundle\Mailer;

interface MailerInterface
{
    /**
     * @param string $from
     * @param string $fromName
     * @param array  $to
     * @param string $subject
     * @param string $body
     * @param array  $attachments
     * @param array  $options
     */
    public function prepare($from, $fromName, array $to, $subject, $body, array $attachments = array(), array $options = array());

    /**
     * Send the mail
     */
    public function send();
}
