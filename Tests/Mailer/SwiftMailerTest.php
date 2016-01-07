<?php

namespace Chris\Bundle\MailBundle\Tests\Mailer;

use Chris\Bundle\MailBundle\Mailer\SwiftMailer;
use \Phake;

class SwiftMailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SwiftMailer $swiftMailer
     */
    protected $swiftMailer;

    /**
     * Set up the send mail test with swiftMailer
     */
    public function setUp()
    {
        parent::setUp();

        $this->swiftMailer = new SwiftMailer(Phake::mock(\Swift_Mailer::class));
    }

    /**
     * Test on the send mail
     */
    public function testSendMail()
    {
        $result = $this->swiftMailer->prepare('fromTest@yopmail.com', 'fromTest', ['totest@yopmail.com'], 'test subject', 'test body')
            ->send();

        $this->assertTrue($result);
    }

    /**
     * Test the failed on the send mail
     */
    public function testFailedSendMail()
    {
        $result = $this->swiftMailer->send();

        $this->assertFalse($result);
    }
}
