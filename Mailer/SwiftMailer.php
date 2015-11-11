<?php

namespace Chris\Bundle\MailBundle\Mailer;

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
    public function prepare($from, $fromName, array $to, $subject, $body, array $attachments = array(), array $options = array())
    {
        $this->mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setBody($body, 'text/html');

        foreach ($to as $receiver) {
            $this->mail->addTo($receiver);
        }

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->mail->attach(\Swift_Attachment::fromPath($attachment));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $this->swiftMailer->send($this->mail);
    }
}
