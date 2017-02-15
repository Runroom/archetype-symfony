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

        $this->assertSame(EntityMetaInformationMotherObject::TITLE, $meta_information->__toString());
        $this->assertSame(EntityMetaInformationMotherObject::ID, $meta_information->getId());
        $this->assertSame(EntityMetaInformationMotherObject::TITLE, $meta_information->getTitle());
        $this->assertSame(EntityMetaInformationMotherObject::DESCRIPTION, $meta_information->getDescription());
    }
}
