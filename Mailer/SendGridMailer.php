<?php

namespace Chris\Bundle\MailBundle\Mailer;

use Alexlbr\EmailLibrary\Mailer\SendGrid\Mailer;
use Alexlbr\EmailLibrary\SendGridMailer;

class SendGridMailer implements MailerInterface
{
    /**
     * @var SendGrid $sendGrid
     */
    protected $sendGrid;

    /**
     * @param SendGrid $sendGrid
     */
    public function __construct(SendGrid $sendGrid)
    {
        $this->sendGrid = $sendGrid;
    }

    /**
     * {@inheritdoc}
     */
    public function send($from, $to, $subject, $body, array $options)
    {
        $mail = new Email($from, $to, $subject, $body);

        $this->sendGrid->send($mail, $options);
    }
}
