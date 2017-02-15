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

        $this->assertSame(MessageMotherObject::KEY, $message->__toString());
        $this->assertSame(MessageMotherObject::ID, $message->getId());
        $this->assertSame(MessageMotherObject::KEY, $message->getKey());
        $this->assertSame(MessageMotherObject::VALUE, $message->getValue());
    }
}
