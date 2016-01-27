<?php

namespace Chris\Bundle\MailBundle\Tests\Mailer;

use \Phake;
use Chris\Bundle\MailBundle\Mailer\SendGridMailer;
use Alexlbr\EmailLibrary\Mailer\SendGrid\Mailer as SendGrid;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SendGridMailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SendGrid $sendGrid
     */
    protected $sendGrid;

    /**
     * @var EventDispatcher $eventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var SendGridMailer $sendGridMailer
     */
    protected $sendGridMailer;

    /**
     * Set up the sendGrid mail test
     */
    public function setUp()
    {
        parent::setUp();

        $this->sendGrid        = Phake::mock(SendGrid::class);
        $this->eventDispatcher = Phake::mock(EventDispatcher::class);
        $this->sendGridMailer  = new SendGridMailer($this->sendGrid, $this->eventDispatcher);
    }

    /**
     * Test on the send mail
     */
    public function testSendMail()
    {
        $this->sendGridMailer
            ->prepare('fromTest@yopmail.com', 'fromTest', ['totest@yopmail.com'], 'test subject', 'test body')
            ->send();

        \Phake::verify($this->sendGrid)->send(\Phake::anyParameters());
    }

    /**
     * Test on the send mail with categories
     */
    public function testSendMailWithCategories()
    {
        $this->sendGridMailer->setCategories(['testCategory'])
            ->prepare('fromTestWithCategory@yopmail.com', 'fromTestWithCategory', ['totestwithcategory@yopmail.com'], 'test subject with category', 'test body with category')
            ->send();

        \Phake::verify($this->sendGrid)->send(\Phake::anyParameters());
    }

    /**
     * Test on the send mail with sendAt
     */
    public function testSendMailWithSendAt()
    {
        $this->sendGridMailer->setSendAt(new \DateTime());
        $this->sendGridMailer
            ->prepare('fromTestWithSendAt@yopmail.com', 'fromTestWithSendAt', ['totestwithsendat@yopmail.com'], 'test subject with sendAt', 'test body with sendAt')
            ->send();

        \Phake::verify($this->sendGrid)->send(\Phake::anyParameters());
    }
}
