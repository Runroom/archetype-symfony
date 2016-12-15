<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Tests\MotherObject\EntityMetaInformationMotherObject;

class EntityMetaInformationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $meta_information = EntityMetaInformationMotherObject::createFilled();

        $this->assertEquals(EntityMetaInformationMotherObject::TITLE, $meta_information->__toString());
        $this->assertEquals(EntityMetaInformationMotherObject::ID, $meta_information->getId());
        $this->assertEquals(EntityMetaInformationMotherObject::TITLE, $meta_information->getTitle());
        $this->assertEquals(EntityMetaInformationMotherObject::DESCRIPTION, $meta_information->getDescription());
    }
}
