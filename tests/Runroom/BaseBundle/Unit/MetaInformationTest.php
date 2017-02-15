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
        $meta_information = MetaInformationMotherObject::createFilled();

        $this->assertSame(MetaInformationMotherObject::ROUTE_NAME, $meta_information->__toString());
        $this->assertSame(MetaInformationMotherObject::ID, $meta_information->getId());
        $this->assertSame(MetaInformationMotherObject::ROUTE, $meta_information->getRoute());
        $this->assertSame(MetaInformationMotherObject::ROUTE_NAME, $meta_information->getRouteName());
        $this->assertSame(MetaInformationMotherObject::IMAGE, $meta_information->getImage());
        $this->assertSame(MetaInformationMotherObject::TITLE, $meta_information->getTitle());
        $this->assertSame(MetaInformationMotherObject::DESCRIPTION, $meta_information->getDescription());
    }
}
