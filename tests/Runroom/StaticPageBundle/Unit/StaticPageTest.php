<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\StaticPageBundle\MotherObject\StaticPageMotherObject;

class StaticPageTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $static_page = StaticPageMotherObject::createFilled();

        $this->assertSame(StaticPageMotherObject::TITLE, $static_page->__toString());
        $this->assertSame(StaticPageMotherObject::ID, $static_page->getId());
        $this->assertSame(StaticPageMotherObject::TITLE, $static_page->getTitle());
        $this->assertSame(StaticPageMotherObject::CONTENT, $static_page->getContent());
        $this->assertSame(StaticPageMotherObject::SLUG, $static_page->getSlug());
        $this->assertSame(StaticPageMotherObject::PUBLISH, $static_page->getPublish());
        $this->assertSame(StaticPageMotherObject::META_INFORMATION, $static_page->getMetaInformation());
    }
}
