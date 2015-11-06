<?php

namespace Chris\Bundle\MailBundle\Mailer;

use Alexlbr\EmailLibrary\Mailer\SendGrid\Mailer;
use Alexlbr\EmailLibrary\SendGridMailer;

class SwiftMailer implements MailerInterface
{
    /**
     * @var Swift_Mailer $swiftMailer
     */
    protected $swiftMailer;

    /**
     * @param Swift_Mailer $swiftMailer
     */
    public function __construct(\Swift_Mailer $swiftMailer)
    {
        $this->swiftMailer = $swiftMailer;
    }

    /**
     * {@inheritdoc}
     */
    public function send($from, $to, $subject, $body, array $options)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/html');

        $this->swiftMailer->send($message);
    }
}
