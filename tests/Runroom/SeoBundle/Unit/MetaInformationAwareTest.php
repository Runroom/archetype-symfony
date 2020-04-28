<?php

namespace Tests\Runroom\SeoBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Runroom\SeoBundle\Entity\EntityMetaInformation;
use Tests\Runroom\SeoBundle\Fixtures\MetaInformationAwareEntity;

class MetaInformationAwareTest extends TestCase
{
    use ProphecyTrait;

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
