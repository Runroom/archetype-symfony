<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Sonata\MediaBundle\Form\Type\MediaType;
use Runroom\BaseBundle\Form\Type\FileType;

class FileTypeTest extends \PHPUnit_Framework_TestCase
{
    const FILE_TYPE = 'file_type';

    public function setUp()
    {
        $this->pool = $this->prophesize('Sonata\MediaBundle\Provider\Pool');

        $this->file_type = new FileType($this->pool->reveal(), FileType::class);
    }

    /**
     * @test
     */
    public function itExtendsFromMediaType()
    {
        $this->assertInstanceOf(MediaType::class, $this->file_type);
    }

    /**
     * @test
     */
    public function itIsFromFileType()
    {
        $this->assertEquals(self::FILE_TYPE, $this->file_type->getBlockPrefix());
        $this->assertEquals(self::FILE_TYPE, $this->file_type->getName());
    }
}
