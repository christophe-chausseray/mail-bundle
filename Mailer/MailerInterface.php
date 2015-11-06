<?php

namespace Chris\Bundle\MailBundle\Mailer;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface MailerInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array  $options
     */
    public function prepare($from, $to, $subject, $body, array $options = array());

    /**
     * Send the mail
     */
    public function send();
}
