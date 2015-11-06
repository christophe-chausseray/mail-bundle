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
     * @var Swift_Message $mail
     */
    protected $mail;

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
    public function prepare($from, $to, $subject, $body, array $options = array())
    {
        $this->mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/html');
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $this->swiftMailer->send($this->mail);
    }
}
