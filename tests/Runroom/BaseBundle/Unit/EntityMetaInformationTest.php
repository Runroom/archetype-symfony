<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\BaseBundle\MotherObject\EntityMetaInformationMotherObject;

class EntityMetaInformationTest extends TestCase
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
