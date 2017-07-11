<?php

namespace Tests\Runroom\TranslationsBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Twig\UnescapeExtension;
use Tests\Runroom\TranslationsBundle\MotherObjects\MessageMotherObject;

class UnescapeExtensionTest extends TestCase
{
    const DECODED = '&quot;Test With&nbsp;Spaces'; // Do not change
    const ENCODED = '&quot;Test&nbsp;With&amp;nbsp;Spaces';
    const FILTERS = 1;

    public function setUp()
    {
        $this->message_extension = new UnescapeExtension();
    }

    /**
     * @test
     */
    public function itDoesAnHtmlEntityDecodeToAString()
    {
        $result = $this->message_extension->unescape(self::ENCODED);

        $this->assertSame(self::DECODED, $result);
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
