<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Sonata\MediaBundle\Form\Type\MediaType;
use Runroom\BaseBundle\Form\Type\ImageType;

class ImageTypeTest extends \PHPUnit_Framework_TestCase
{
    const IMAGE_TYPE = 'image_type';

    public function setUp()
    {
        $this->pool = $this->prophesize('Sonata\MediaBundle\Provider\Pool');

        $this->image_type = new ImageType($this->pool->reveal(), ImageType::class);
    }

    /**
     * @test
     */
    public function itExtendsFromMediaType()
    {
        $this->assertInstanceOf(MediaType::class, $this->image_type);
    }

    /**
     * @test
     */
    public function itIsFromImageType()
    {
        $this->assertEquals(self::IMAGE_TYPE, $this->image_type->getBlockPrefix());
        $this->assertEquals(self::IMAGE_TYPE, $this->image_type->getName());
    }
}
