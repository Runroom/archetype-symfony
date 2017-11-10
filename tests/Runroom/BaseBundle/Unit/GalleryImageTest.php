<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\BaseBundle\MotherObject\GalleryImageMotherObject;

class GalleryImageTest extends TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $galleryImage = GalleryImageMotherObject::createFilled();

        $this->assertSame(GalleryImageMotherObject::ID, $galleryImage->getId());
        $this->assertSame(GalleryImageMotherObject::IMAGE, $galleryImage->getImage());
        $this->assertSame(GalleryImageMotherObject::GALLERY, $galleryImage->getGallery());
        $this->assertSame(GalleryImageMotherObject::POSITION, $galleryImage->getPosition());
    }
}
