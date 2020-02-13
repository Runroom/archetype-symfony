<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Entity\EntityMetaInformation;
use Tests\Runroom\BaseBundle\Fixtures\MetaInformationAwareEntity;

class MetaInformationAwareTest extends TestCase
{
    /**
     * @test
     */
    public function itSetsAndGetsMetaInformation()
    {
        $entityMetaInformation = $this->prophesize(EntityMetaInformation::class);
        $metaInformationAware = new MetaInformationAwareEntity();

        $expected = $entityMetaInformation->reveal();
        $metaInformationAware = $metaInformationAware->setMetaInformation($expected);

        $this->assertEquals($expected, $metaInformationAware->getMetaInformation());
    }
}
