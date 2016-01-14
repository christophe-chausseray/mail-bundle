<?php

namespace Chris\Bundle\MailBundle\Tests\Mailer;

use Chris\Bundle\MailBundle\Mailer\SwiftMailer;
use \Phake;

class SwiftMailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Swift_Mailer
     */
    protected $swift;
    
    /**
     * @var SwiftMailer
     */
    protected $swiftMailer;

    /**
     * Set up the send mail test with swiftMailer
     */
    public function setUp()
    {
        parent::setUp();

        $this->swift       = Phake::mock(\Swift_Mailer::class);
        $this->swiftMailer = new SwiftMailer($this->swift);
    }

    /**
     * Test on the send mail
     */
    public function testSendMail()
    {
        $this->swiftMailer->prepare('fromTest@yopmail.com', 'fromTest', ['totest@yopmail.com'], 'test subject', 'test body')
            ->send();

        \Phake::verify($this->swift)->send(\Phake::anyParameters());
    }
}
