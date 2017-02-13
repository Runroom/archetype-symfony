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

        $this->assertEquals(MetaInformationMotherObject::ROUTE_NAME, $meta_information->__toString());
        $this->assertEquals(MetaInformationMotherObject::ID, $meta_information->getId());
        $this->assertEquals(MetaInformationMotherObject::ROUTE, $meta_information->getRoute());
        $this->assertEquals(MetaInformationMotherObject::ROUTE_NAME, $meta_information->getRouteName());
        $this->assertEquals(MetaInformationMotherObject::IMAGE, $meta_information->getImage());
        $this->assertEquals(MetaInformationMotherObject::TITLE, $meta_information->getTitle());
        $this->assertEquals(MetaInformationMotherObject::DESCRIPTION, $meta_information->getDescription());
    }
}
