<?php

namespace Runroom\TranslationsBundle\Tests\Unit;

use Runroom\TranslationsBundle\Tests\MotherObjects\MessageMotherObject;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itImplementsTheToStringMethod()
    {
        $message = MessageMotherObject::create();

        $this->assertEquals(MessageMotherObject::KEY, $message->__toString());
        $this->assertEquals(MessageMotherObject::ID, $message->getId());
        $this->assertEquals(MessageMotherObject::KEY, $message->getKey());
        $this->assertEquals(MessageMotherObject::VALUE, $message->getValue());
    }
}
