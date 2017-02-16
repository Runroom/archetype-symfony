<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Form\Type\MediaType;
use Sonata\MediaBundle\Form\Type\MediaType as BaseMediaType;

class MediaTypeTest extends TestCase
{
    /**
     * @test
     */
    public function itIsAParentFromBaseMediaType()
    {
        $media_type = new MediaType();

        $this->assertSame(BaseMediaType::class, $media_type->getParent());
    }
}
