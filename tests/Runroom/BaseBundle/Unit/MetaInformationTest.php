<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\BaseBundle\MotherObject\MetaInformationMotherObject;

class MetaInformationTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $metaInformation = MetaInformationMotherObject::createFilled();

        $this->assertSame(MetaInformationMotherObject::ROUTE_NAME, $metaInformation->__toString());
        $this->assertSame(MetaInformationMotherObject::ID, $metaInformation->getId());
        $this->assertSame(MetaInformationMotherObject::ROUTE, $metaInformation->getRoute());
        $this->assertSame(MetaInformationMotherObject::ROUTE_NAME, $metaInformation->getRouteName());
        $this->assertSame(MetaInformationMotherObject::IMAGE, $metaInformation->getImage());
        $this->assertSame(MetaInformationMotherObject::TITLE, $metaInformation->getTitle());
        $this->assertSame(MetaInformationMotherObject::DESCRIPTION, $metaInformation->getDescription());
    }
}
