<?php

namespace Runroom\TranslationsBundle\Tests\Unit;

use Runroom\TranslationsBundle\Tests\MotherObjects\MessageMotherObject;
use Runroom\TranslationsBundle\Twig\MessageExtension;

class MessageExtensionTest extends \PHPUnit_Framework_TestCase
{
    const LOCALE = 'en';
    const EXTENSION_NAME = 'message_extension';

    public function setUp()
    {
        $this->service = $this->prophesize('Runroom\TranslationsBundle\Service\MessageService');

        $this->message_extension = new MessageExtension(
            $this->service->reveal()
        );
    }

    /**
     * @test
     */
    public function itTranslatesThroughMessageService()
    {
        $expected_result = MessageMotherObject::VALUE;

        $this->service->message(MessageMotherObject::KEY, [], null)
            ->willReturn($expected_result);

        $result = $this->message_extension->message(MessageMotherObject::KEY);

        $this->assertSame($expected_result, $result);
    }
}
