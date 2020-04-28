<?php

namespace Tests\Runroom\SeoBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\SeoBundle\Fixtures\MetaInformationFixture;

class MetaInformationTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $metaInformation = MetaInformationFixture::create();

        $this->assertSame(MetaInformationFixture::ROUTE_NAME, $metaInformation->__toString());
        $this->assertSame(MetaInformationFixture::ID, $metaInformation->getId());
        $this->assertSame(MetaInformationFixture::ROUTE, $metaInformation->getRoute());
        $this->assertSame(MetaInformationFixture::ROUTE_NAME, $metaInformation->getRouteName());
        $this->assertSame(MetaInformationFixture::IMAGE, $metaInformation->getImage());
        $this->assertSame(MetaInformationFixture::TITLE, $metaInformation->getTitle());
        $this->assertSame(MetaInformationFixture::DESCRIPTION, $metaInformation->getDescription());
    }
}
