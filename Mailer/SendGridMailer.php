<?php

use SendGrid\Email;

class SendGridMailer
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
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array  $options
     */
    public function send($from, $to, $subject, $body, array $options)
    {
        $mail = new Email($from, $to, $subject, $body);

        $this->sendGrid->send($mail, $options);
    }
}
