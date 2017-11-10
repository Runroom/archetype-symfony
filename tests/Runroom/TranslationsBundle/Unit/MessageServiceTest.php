<?php

namespace Tests\Runroom\TranslationsBundle\Unit;

use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Runroom\TranslationsBundle\Service\MessageService;
use Symfony\Component\Translation\TranslatorInterface;
use Tests\Runroom\TranslationsBundle\MotherObjects\MessageMotherObject;

class MessageServiceTest extends TestCase
{
    const LOCALE = 'en';

    protected function setUp()
    {
        $this->repository = $this->prophesize(EntityRepository::class);
        $this->translator = $this->prophesize(TranslatorInterface::class);

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

        $this->repository->findOneBy(['key' => MessageMotherObject::KEY])->willReturn($message);
        $this->translator->trans(MessageMotherObject::KEY, [], null, self::LOCALE)->shouldNotBeCalled();

        $result = $this->service->message(MessageMotherObject::KEY, [], self::LOCALE);

        $this->assertSame(MessageMotherObject::VALUE, $result);
        $this->assertSame(MessageMotherObject::KEY, $message->getKey());
        $this->assertSame(MessageMotherObject::VALUE, $message->getValue());
    }

    /**
     * @test
     */
    public function itReturnsAStringTranslatedByTheTranslatorComponentAfterNotFindingItInTheDatabase()
    {
        $this->repository->findOneBy(['key' => MessageMotherObject::KEY])->willReturn(null);
        $this->translator->trans(MessageMotherObject::KEY, [], null, self::LOCALE)
            ->willReturn(MessageMotherObject::VALUE);

        $result = $this->service->message(MessageMotherObject::KEY, [], self::LOCALE);

        $this->assertSame(MessageMotherObject::VALUE, $result);
    }
}
