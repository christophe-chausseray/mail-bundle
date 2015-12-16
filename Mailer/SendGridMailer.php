<?php

namespace Chris\Bundle\MailBundle\Mailer;

use Alexlbr\EmailLibrary\Email;
use Alexlbr\EmailLibrary\EmailInterface;
use Alexlbr\EmailLibrary\Mailer\MailerException;
use Alexlbr\EmailLibrary\Mailer\SendGrid\EmailDecorator;
use Alexlbr\EmailLibrary\Mailer\SendGrid\Mailer as SendGrid;
use Chris\Bundle\MailBundle\Event\EmailEvent;
use Chris\Bundle\MailBundle\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendGridMailer implements MailerInterface
{
    /**
     * @var SendGrid $sendGrid
     */
    protected $sendGrid;

    /**
     * @var null|array $categories
     */
    protected $categories = null;

    /**
     * @var EmailInterface[] $mailList
     */
    protected $mailList;

    /**
     * @var array $options
     */
    protected $options;

    /**
     * @var LoggerInterface|null $logger
     */
    protected $logger;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @var integer
     */
    protected $sendAt;

    /**
     * @param SendGrid                 $sendGrid
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(SendGrid $sendGrid, EventDispatcherInterface $dispatcher)
    {
        $this->sendGrid   = $sendGrid;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param LoggerInterface|null $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Set Categories
     *
     * @param array|null $categories
     *
     * @return $this
     */
    public function setCategories(array $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Set sentAt timestamp to delay email
     *
     * @param integer|null $timestamp
     */
    public function setSendAt($timestamp = null)
    {
        $this->sendAt = $timestamp;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    protected function resolveOptions(array $options = [])
    {
        $defaultOptions = [];

        if (is_array($this->categories)) {
            $defaultOptions['categories'] = $this->categories;
        }

        $this->options = array_merge($defaultOptions, $options);

        return $this;
    }

    /**
     * @param EmailInterface $email
     * @return $this
     */
    protected function addEmail(EmailInterface $email)
    {
        if (!is_array($this->mailList)) {
            $this->mailList = [];
        }

        $this->mailList[] = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($from, $fromName, array $to, $subject, $body, array $attachments = [], array $options = [])
    {
        $this->resolveOptions($options);

        $email = new Email($from, $fromName, $to, $subject, $body, htmlspecialchars($body));

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $email->addAttachment($attachment);
            }
        }

        if (!is_null($this->sendAt)) {
            $email = new EmailDecorator($email);
            $email->setSendAt($this->sendAt);
        }

        $this->addEmail($email);

        return $this;
    }

    /**
     * {@inheridoc}
     */
    public function send()
    {
        $mailsToSend = $this->mailList;

        while (is_array($mailsToSend) && ($mail = array_shift($mailsToSend)) && $mail instanceof EmailInterface) {
            if (!(is_array($this->options))) {
                throw new MailerException('You need to prepare the mail that will be sent.');
            }

            $emailEvent = new EmailEvent($mail);

            $this->dispatcher->dispatch(
                Events::STORE_EMAIL,
                $emailEvent
            );

            if (true === $emailEvent->isCanceled()) {
                $this->loggerDebug('The email is canceled by the application.');
            } else {
                $this->sendGrid->send($mail);
            }
        }

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    protected function loggerDebug($message)
    {
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->debug($message);
        }

        return $this;
    }
}
