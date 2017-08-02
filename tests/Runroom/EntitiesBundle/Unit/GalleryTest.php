<?php

namespace Tests\Runroom\EntitiesBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\EntitiesBundle\MotherObject\GalleryImageMotherObject;
use Tests\Runroom\EntitiesBundle\MotherObject\GalleryMotherObject;

class GalleryTest extends TestCase
{
    /**
     * @test
     */
    public function itAddsAndRemovesGalleryImages()
    {
        $gallery = GalleryMotherObject::createFilled();

        $this->assertSame(GalleryMotherObject::ID, $gallery->getId());

        $galleryImage = GalleryImageMotherObject::createFilled();

        $gallery->addGalleryImage($galleryImage);

        $galleryImages = $gallery->getGalleryImages();

        $this->assertCount(1, $galleryImages);
        $this->assertSame(GalleryImageMotherObject::ID, $galleryImages[0]->getId());

        $gallery->removeGalleryImage($galleryImage);

        $this->assertCount(0, $galleryImages);
    }
}
