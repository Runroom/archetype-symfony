<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Behaviors\MetaInformationAware;
use Runroom\BaseBundle\Entity\EntityMetaInformation;

class MetaInformationAwareTest extends TestCase
{
    /**
     * @test
     */
    public function itSetsAndGetsMetaInformation()
    {
        $entityMetaInformation = $this->prophesize(EntityMetaInformation::class);
        $metaInformationAware = $this->getMockForTrait(MetaInformationAware::class);

        $expected = $entityMetaInformation->reveal();
        $metaInformationAware = $metaInformationAware->setMetaInformation($expected);

        $this->assertEquals($expected, $metaInformationAware->getMetaInformation());
    }
}
