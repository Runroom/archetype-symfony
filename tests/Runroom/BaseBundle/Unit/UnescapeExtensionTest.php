<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Twig\UnescapeExtension;

class UnescapeExtensionTest extends TestCase
{
    const DECODED = '&quot;Test With&nbsp;Spaces';
    const ENCODED = '&quot;Test&nbsp;With&amp;nbsp;Spaces';
    const FILTERS = 1;

    protected function setUp()
    {
        $this->messageExtension = new UnescapeExtension();
    }

    /**
     * @test
     */
    public function itDoesAnHtmlEntityDecodeToAString()
    {
        $result = $this->messageExtension->unescape(self::ENCODED);

        $this->assertSame(self::DECODED, $result);
    }

    /**
     * @test
     */
    public function itDefinesAFilter()
    {
        $filters = $this->messageExtension->getFilters();

        $this->assertCount(self::FILTERS, $filters);
    }
}
