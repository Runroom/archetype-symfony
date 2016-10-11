<?php

namespace Runroom\TranslationsBundle\Tests\Unit;

use Runroom\TranslationsBundle\Entity\Message;
use Runroom\TranslationsBundle\Tests\MotherObjects\MessageMotherObject;
use Runroom\TranslationsBundle\Twig\MessageExtension;

class MessageExtensionTest extends \PHPUnit_Framework_TestCase
{
    const LOCALE = 'en';
    const EXTENSION_NAME = 'message_extension';

    public function setUp()
    {
        $this->repository = $this->prophesize('Doctrine\ORM\EntityRepository');
        $this->translator = $this->prophesize('Symfony\Component\Translation\TranslatorInterface');

        $this->message_extension = new MessageExtension(
            $this->repository->reveal(),
            $this->translator->reveal()
        );
    }

    /**
     * @test
     */
    public function itReturnsAnEmptyStringForAnUnknownKey()
    {
        $this->translator->trans(MessageMotherObject::KEY, [], null, self::LOCALE)
            ->willReturn(MessageMotherObject::KEY);

        $result = $this->message_extension->getMessageValue(
            MessageMotherObject::KEY,
            self::LOCALE
        );

        $this->assertEquals('', $result);
    }

    /**
     * @test
     */
    public function itReturnsAStringTranslatedByTheTranslatorComponent()
    {
        $this->translator->trans(MessageMotherObject::KEY, [], null, self::LOCALE)
            ->willReturn(MessageMotherObject::VALUE);

        $result = $this->message_extension->getMessageValue(
            MessageMotherObject::KEY,
            self::LOCALE
        );

        $this->assertEquals(MessageMotherObject::VALUE, $result);
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

        $result = $this->message_extension->getMessageValue(
            MessageMotherObject::KEY,
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

        $result = $this->message_extension->getMessageValue(
            MessageMotherObject::KEY,
            self::LOCALE
        );

        $this->assertEquals(MessageMotherObject::VALUE, $result);
    }

    /**
     * @test
     */
    public function itImplementsTheGetNameMethod()
    {
        $result = $this->message_extension->getName();

        $this->assertEquals(self::EXTENSION_NAME, $result);
    }
}
