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
        $mediaType = new MediaType();

        $this->assertSame(BaseMediaType::class, $mediaType->getParent());
    }
}
