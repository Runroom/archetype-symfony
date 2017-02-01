<?php

namespace Tests\Runroom\TranslationsBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\TranslationsBundle\MotherObjects\MessageMotherObject;

class MessageTest extends TestCase
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
