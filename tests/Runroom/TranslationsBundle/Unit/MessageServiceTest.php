<?php

namespace Tests\Runroom\TranslationsBundle\Unit;

use Runroom\TranslationsBundle\Service\MessageService;
use Tests\Runroom\TranslationsBundle\MotherObjects\MessageMotherObject;

class MessageServiceTest extends \PHPUnit_Framework_TestCase
{
    const LOCALE = 'en';

    public function setUp()
    {
        $this->repository = $this->prophesize('Doctrine\ORM\EntityRepository');
        $this->translator = $this->prophesize('Symfony\Component\Translation\TranslatorInterface');

        $this->service = new MessageService(
            $this->repository->reveal(),
            $this->translator->reveal()
        );
    }

    /**
     * @test
     */
    public function itReturnsAStringTranslatedByTheRepository()
    {
        $message = MessageMotherObject::create();

        $this->repository->findOneBy(['key' => MessageMotherObject::KEY])
            ->willReturn($message);

        $this->translator->trans(MessageMotherObject::KEY, [], null, self::LOCALE)
            ->shouldNotBeCalled();

        $result = $this->service->message(
            MessageMotherObject::KEY,
            [],
            self::LOCALE
        );

        $this->assertEquals(MessageMotherObject::VALUE, $result);
        $this->assertEquals(MessageMotherObject::KEY, $message->getKey());
        $this->assertEquals(MessageMotherObject::VALUE, $message->getValue());
    }

    /**
     * @test
     */
    public function itReturnsAStringTranslatedByTheTranslatorComponentAfterNotFindingItInTheDatabase()
    {
        $this->repository->findOneBy(['key' => MessageMotherObject::KEY])
            ->willReturn(null);

        $this->translator->trans(MessageMotherObject::KEY, [], null, self::LOCALE)
            ->willReturn(MessageMotherObject::VALUE);

        $result = $this->service->message(
            MessageMotherObject::KEY,
            [],
            self::LOCALE
        );

        $this->assertEquals(MessageMotherObject::VALUE, $result);
    }
}
