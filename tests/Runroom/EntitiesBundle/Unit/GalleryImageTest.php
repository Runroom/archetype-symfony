<?php

namespace Tests\Runroom\EntitiesBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\EntitiesBundle\MotherObject\GalleryImageMotherObject;

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
