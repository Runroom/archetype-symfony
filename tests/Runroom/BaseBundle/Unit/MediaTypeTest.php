<?php

namespace Tests\Runroom\BaseBundle\Unit;

use Runroom\BaseBundle\Form\Type\MediaType;
use Sonata\MediaBundle\Form\Type\MediaType as BaseMediaType;

class MediaTypeTest extends \PHPUnit_Framework_TestCase
{
    const IMAGE_TYPE = 'media_type';

    public function setUp()
    {
        $this->pool = $this->prophesize('Sonata\MediaBundle\Provider\Pool');

        $this->media_type = new MediaType($this->pool->reveal(), MediaType::class);
    }

    /**
     * @test
     */
    public function itExtendsFromMediaType()
    {
        $this->assertInstanceOf(BaseMediaType::class, $this->media_type);
    }

    /**
     * @test
     */
    public function itIsFromImageType()
    {
        $this->assertEquals(self::IMAGE_TYPE, $this->media_type->getBlockPrefix());
        $this->assertEquals(self::IMAGE_TYPE, $this->media_type->getName());
    }
}
