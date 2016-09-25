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
        $entity_meta_information = EntityMetaInformationMotherObject::createFilled();

        $this->assertEquals(EntityMetaInformationMotherObject::TITLE, $entity_meta_information->__toString());
        $this->assertEquals(EntityMetaInformationMotherObject::ID, $entity_meta_information->getId());
        $this->assertEquals(EntityMetaInformationMotherObject::TITLE, $entity_meta_information->getTitle());
        $this->assertEquals(EntityMetaInformationMotherObject::DESCRIPTION, $entity_meta_information->getDescription());
    }
}
