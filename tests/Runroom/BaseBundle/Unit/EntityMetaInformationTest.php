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
        $metaInformation = EntityMetaInformationMotherObject::create();

        $this->assertSame(EntityMetaInformationMotherObject::TITLE, $metaInformation->__toString());
        $this->assertSame(EntityMetaInformationMotherObject::ID, $metaInformation->getId());
        $this->assertSame(EntityMetaInformationMotherObject::TITLE, $metaInformation->getTitle());
        $this->assertSame(EntityMetaInformationMotherObject::DESCRIPTION, $metaInformation->getDescription());
    }
}
