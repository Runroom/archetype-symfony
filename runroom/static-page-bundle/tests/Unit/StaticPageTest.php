<?php

namespace Runroom\StaticPageBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\SeoBundle\Entity\EntityMetaInformation;
use Runroom\StaticPageBundle\Tests\Fixtures\StaticPageFixture;

class StaticPageTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $staticPage = StaticPageFixture::create();

        $this->assertSame(StaticPageFixture::TITLE, $staticPage->__toString());
        $this->assertSame(StaticPageFixture::ID, $staticPage->getId());
        $this->assertSame(StaticPageFixture::TITLE, $staticPage->getTitle());
        $this->assertSame(StaticPageFixture::LOCATION, $staticPage->getLocation());
        $this->assertSame(StaticPageFixture::CONTENT, $staticPage->getContent());
        $this->assertSame(StaticPageFixture::SLUG, $staticPage->getSlug());
        $this->assertSame(StaticPageFixture::PUBLISH, $staticPage->getPublish());
        $this->assertInstanceOf(EntityMetaInformation::class, $staticPage->getMetaInformation());
    }
}
