<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\BaseBundle\MotherObject\GalleryImageMotherObject;
use Tests\Runroom\BaseBundle\MotherObject\GalleryMotherObject;

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
