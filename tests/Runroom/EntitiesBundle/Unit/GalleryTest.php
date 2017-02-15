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

        $gallery_image = GalleryImageMotherObject::createFilled();

        $gallery->addGalleryImage($gallery_image);

        $gallery_images = $gallery->getGalleryImages();

        $this->assertCount(1, $gallery_images);
        $this->assertSame(GalleryImageMotherObject::ID, $gallery_images[0]->getId());

        $gallery->removeGalleryImage($gallery_image);

        $this->assertCount(0, $gallery_images);
    }
}
