<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Twig\UnescapeExtension;

class UnescapeExtensionTest extends TestCase
{
    protected const DECODED = '&quot;Test With&nbsp;Spaces';
    protected const ENCODED = '&quot;Test&nbsp;With&amp;nbsp;Spaces';
    protected const FILTERS = 1;

    protected $messageExtension;

    protected function setUp(): void
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
