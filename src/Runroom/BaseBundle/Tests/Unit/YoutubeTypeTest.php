<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Sonata\MediaBundle\Form\Type\MediaType;
use Runroom\BaseBundle\Form\Type\YoutubeType;

class YoutubeTypeTest extends \PHPUnit_Framework_TestCase
{
    const YOUTUBE_TYPE = 'youtube_type';

    public function setUp()
    {
        $this->pool = $this->prophesize('Sonata\MediaBundle\Provider\Pool');

        $this->youtube_type = new YoutubeType($this->pool->reveal(), YoutubeType::class);
    }

    /**
     * @test
     */
    public function itExtendsFromMediaType()
    {
        $this->assertInstanceOf(MediaType::class, $this->youtube_type);
    }

    /**
     * @test
     */
    public function itIsFromYoutubeType()
    {
        $this->assertEquals(self::YOUTUBE_TYPE, $this->youtube_type->getBlockPrefix());
        $this->assertEquals(self::YOUTUBE_TYPE, $this->youtube_type->getName());
    }
}
