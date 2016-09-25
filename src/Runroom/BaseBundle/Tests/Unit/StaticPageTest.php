<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Tests\MotherObject\StaticPageMotherObject;

class StaticPageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $static_page = StaticPageMotherObject::createFilled();

        $this->assertEquals(StaticPageMotherObject::TITLE, $static_page->__toString());
        $this->assertEquals(StaticPageMotherObject::ID, $static_page->getId());
        $this->assertEquals(StaticPageMotherObject::TITLE, $static_page->getTitle());
        $this->assertEquals(StaticPageMotherObject::CONTENT, $static_page->getContent());
        $this->assertEquals(StaticPageMotherObject::BREADCRUMB, $static_page->getBreadcrumb());
        $this->assertEquals(StaticPageMotherObject::LOCATION, $static_page->getLocation());
        $this->assertEquals(StaticPageMotherObject::SLUG, $static_page->getSlug());
        $this->assertEquals(StaticPageMotherObject::POSITION, $static_page->getPosition());
        $this->assertEquals(StaticPageMotherObject::PUBLISH, $static_page->getPublish());
        $this->assertEquals(StaticPageMotherObject::META_INFORMATION, $static_page->getMetaInformation());
    }
}
