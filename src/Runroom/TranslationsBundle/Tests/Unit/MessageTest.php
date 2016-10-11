<?php

namespace Runroom\TranslationsBundle\Tests\Unit;

use Runroom\TranslationsBundle\Entity\Message;
use Runroom\TranslationsBundle\Tests\MotherObjects\MessageMotherObject;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    const DEFAULT_STRING = 'Message';

    /**
     * @test
     */
    public function itImplementsTheToStringMethod()
    {
        $this->message = MessageMotherObject::create();

        $result = $this->message->__toString();

        $this->assertEquals(self::DEFAULT_STRING, $result);
    }
}
