<?php

namespace Tests\Runroom\StaticPageBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Entity\EntityMetaInformation;
use Tests\Runroom\StaticPageBundle\MotherObject\StaticPageMotherObject;

class StaticPageTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $staticPage = StaticPageMotherObject::create();

        $this->assertSame(StaticPageMotherObject::TITLE, $staticPage->__toString());
        $this->assertSame(StaticPageMotherObject::ID, $staticPage->getId());
        $this->assertSame(StaticPageMotherObject::TITLE, $staticPage->getTitle());
        $this->assertSame(StaticPageMotherObject::LOCATION, $staticPage->getLocation());
        $this->assertSame(StaticPageMotherObject::CONTENT, $staticPage->getContent());
        $this->assertSame(StaticPageMotherObject::SLUG, $staticPage->getSlug());
        $this->assertSame(StaticPageMotherObject::PUBLISH, $staticPage->getPublish());
        $this->assertInstanceOf(EntityMetaInformation::class, $staticPage->getMetaInformation());
    }
}
