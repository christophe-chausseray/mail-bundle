<?php

namespace Chris\Bundle\MailBundle\Mailer;

use Alexlbr\EmailLibrary\Mailer\SendGrid\Mailer;
use Alexlbr\EmailLibrary\Mailer\MailerException;
use Alexlbr\EmailLibrary\SendGridMailer as SendGrid;

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
     * @var Email $mail
     */
    protected $mail;

    /**
     * @var array $options
     */
    protected $options;

    /**
     * @param SendGrid $sendGrid
     */
    public function __construct(SendGrid $sendGrid)
    {
        $this->sendGrid = $sendGrid;
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
     * {@inheritdoc}
     */
    public function prepare($from, $to, $subject, $body, array $options = array())
    {
        $this->mail = new Mailer($from, $to, $subject, $body);
        $this->resolveOptions($options);

        return $this;
    }

    /**
     * {@inheridoc}
     */
    public function send()
    {
        if(!($this->mail instanceof Mailer) && !is_array($this->options)) {
            throw new MailerException('You need to prepare the mail that will be send');
        }

        $this->sendGrid->send($this->mail, $this->options);
    }
}
