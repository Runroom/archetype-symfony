<?php

namespace Tests\Runroom\SeoBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\SeoBundle\Fixtures\EntityMetaInformationFixture;

class EntityMetaInformationTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $metaInformation = EntityMetaInformationFixture::create();

        $this->assertSame(EntityMetaInformationFixture::TITLE, $metaInformation->__toString());
        $this->assertSame(EntityMetaInformationFixture::ID, $metaInformation->getId());
        $this->assertSame(EntityMetaInformationFixture::TITLE, $metaInformation->getTitle());
        $this->assertSame(EntityMetaInformationFixture::DESCRIPTION, $metaInformation->getDescription());
    }
}
