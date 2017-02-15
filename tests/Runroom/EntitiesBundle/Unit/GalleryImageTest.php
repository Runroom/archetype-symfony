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
        $gallery_image = GalleryImageMotherObject::createFilled();

        $this->assertSame(GalleryImageMotherObject::ID, $gallery_image->getId());
        $this->assertSame(GalleryImageMotherObject::IMAGE, $gallery_image->getImage());
        $this->assertSame(GalleryImageMotherObject::GALLERY, $gallery_image->getGallery());
        $this->assertSame(GalleryImageMotherObject::POSITION, $gallery_image->getPosition());
    }
}
