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
        $staticPage = StaticPageMotherObject::createFilled();

        $this->assertSame(StaticPageMotherObject::TITLE, $staticPage->__toString());
        $this->assertSame(StaticPageMotherObject::ID, $staticPage->getId());
        $this->assertSame(StaticPageMotherObject::TITLE, $staticPage->getTitle());
        $this->assertSame(StaticPageMotherObject::CONTENT, $staticPage->getContent());
        $this->assertSame(StaticPageMotherObject::SLUG, $staticPage->getSlug());
        $this->assertSame(StaticPageMotherObject::PUBLISH, $staticPage->getPublish());
        $this->assertSame(StaticPageMotherObject::META_INFORMATION, $staticPage->getMetaInformation());
    }
}
