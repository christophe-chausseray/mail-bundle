<?php

namespace Chris\Bundle\MailBundle\Tests\Mailer;

use Chris\Bundle\MailBundle\Mailer\SendGridMailer;

use \Phake;
use Alexlbr\EmailLibrary\Mailer\SendGrid\Mailer as SendGrid;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SendGridMailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SendGrid $sendGrid
     */
    protected $sendGrid;

    /**
     * @var eventDispatcher $eventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var sendGridMailer $sendGridMailer
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
        $result = $this->sendGridMailer
            ->prepare('fromTest@yopmail.com', 'fromTest', ['totest@yopmail.com'], 'test subject', 'test body')
            ->send();

        $this->assertTrue($result);
    }

    /**
     * Test on the send mail with categories
     */
    public function testSendMailWithCategories()
    {
        $result = $this->sendGridMailer->setCategories(['testCategory'])
            ->prepare('fromTestWithCategory@yopmail.com', 'fromTestWithCategory', ['totestwithcategory@yopmail.com'], 'test subject with category', 'test body with category')
            ->send();

        $this->assertTrue($result);
    }

    /**
     * Test the fail on the send mail
     */
    public function testFailSendMail()
    {
        $result = $this->sendGridMailer->send();

        $this->assertFalse($result);
    }
}
