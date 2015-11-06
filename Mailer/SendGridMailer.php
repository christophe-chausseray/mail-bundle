<?php

namespace Chris\Bundle\MailBundle\Mailer;

use Alexlbr\EmailLibrary\Email;
use Alexlbr\EmailLibrary\Mailer\MailerException;
use Alexlbr\EmailLibrary\SendGridMailer as SendGrid;
use Chris\Bundle\MailBundle\Event\EmailEvent;
use Chris\Bundle\MailBundle\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher;

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
     * @var Email[] $mailList
     */
    protected $mailList;

    /**
     * @var array $options
     */
    protected $options;

    /**
     * @var LoggerInterface $logger
     */
    protected $logger;

    /**
     * @var
     */
    protected $eventDispatcher;

    /**
     * @param SendGrid        $sendGrid
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(SendGrid $sendGrid, EventDispatcher $eventDispatcher)
    {
        $this->sendGrid = $sendGrid;
        $this->eventDispatcher = $eventDispatcher;
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

    protected function resolveOptions(array $options = array())
    {
        $defaultOptions = [];

        if (is_array($this->categories)) {
            $defaultOptions['categories'] = $this->categories;
        }

        $this->options = array_merge($defaultOptions, $options);

        return $this;
    }

    /**
     * @param Email $email
     *
     * @return $this
     */
    protected function addEmail(Email $email)
    {
        if (!is_array($this->mailList)) {
            $this->mailList = array();
        }

        $this->mailList[] = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($from, $to, $subject, $body, array $options = array())
    {
        $this->resolveOptions($options);
        $this->addEmail(new Email($from, $to, $subject, $body, $this->options));

        return $this;
    }

    /**
     * {@inheridoc}
     */
    public function send()
    {
        $mailsToSend = $this->mailList;

        while (is_array($mailsToSend)) {
            $mail = array_shift($mailsToSend);
            if (!($mail instanceof Mailer) && !is_array($this->options)) {
                throw new MailerException('You need to prepare the mail that will be sent.');
            }

            $emailEvent = new EmailEvent($this->mail);

            $this->eventDispatcher->dispatch(
                Events::STORE_EMAIL,
                $emailEvent
            );

            if (true === $emailEvent->getIsCanceled()) {
                $this->loggerDebug('The email is canceled by the application.');
            } else {
                $this->sendGrid->send($this->mail);
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
