<?php

namespace Tests\Runroom\TranslationsBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\TranslationsBundle\Twig\MessageExtension;
use Tests\Runroom\TranslationsBundle\MotherObjects\MessageMotherObject;

class MessageExtensionTest extends TestCase
{
    const FILTERS = 1;

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

    /**
     * @test
     */
    public function itDefinesAFilter()
    {
        $filters = $this->message_extension->getFilters();

        $this->assertCount(self::FILTERS, $filters);
    }
}
