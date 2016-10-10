<?php

namespace Runroom\TranslationsBundle\Tests\Unit;

use Runroom\TranslationsBundle\Entity\Message;
use Runroom\TranslationsBundle\Twig\MessageExtension;

class MessageExtensionTest extends \PHPUnit_Framework_TestCase
{
    const LOCALE = 'en';
    const TRANSLATION_KEY = 'my.key';
    const TRANSLATION_VALUE = 'My value';

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
        $this->translator->trans(self::TRANSLATION_KEY, [], null, self::LOCALE)
            ->willReturn(self::TRANSLATION_KEY);

        $result = $this->message_extension->getMessageValue(
            self::TRANSLATION_KEY,
            self::LOCALE
        );

        $this->assertEquals('', $result);
    }

    /**
     * @test
     */
    public function itReturnsAStringTranslatedByTheTranslatorComponent()
    {
        $this->translator->trans(self::TRANSLATION_KEY, [], null, self::LOCALE)
            ->willReturn(self::TRANSLATION_VALUE);

        $result = $this->message_extension->getMessageValue(
            self::TRANSLATION_KEY,
            self::LOCALE
        );

        $this->assertEquals(self::TRANSLATION_VALUE, $result);
    }

    /**
     * @test
     */
    public function itReturnsAStringTranslatedByTheRepository()
    {
        $message = new Message();
        $message->setKey(self::TRANSLATION_KEY);
        $message->setValue(self::TRANSLATION_VALUE);

        $this->repository->findOneBy(['key' => self::TRANSLATION_KEY])
            ->willReturn($message);
        $this->translator->trans(self::TRANSLATION_KEY, [], null, self::LOCALE)
            ->shouldNotBeCalled();

        $result = $this->message_extension->getMessageValue(
            self::TRANSLATION_KEY,
            self::LOCALE
        );

        $this->assertEquals(self::TRANSLATION_VALUE, $result);
    }

    /**
     * @test
     */
    public function itReturnsAStringTranslatedByTheTranslatorComponentAfterNotFindingItInTheDatabase()
    {
        $this->repository->findOneBy(['key' => self::TRANSLATION_KEY])
            ->willReturn(null);
        $this->translator->trans(self::TRANSLATION_KEY, [], null, self::LOCALE)
            ->willReturn(self::TRANSLATION_VALUE);

        $result = $this->message_extension->getMessageValue(
            self::TRANSLATION_KEY,
            self::LOCALE
        );

        $this->assertEquals(self::TRANSLATION_VALUE, $result);
    }
}
