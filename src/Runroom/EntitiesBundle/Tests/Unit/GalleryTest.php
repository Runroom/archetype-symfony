<?php

namespace Runroom\EntitiesBundle\Tests\Unit;

use Runroom\EntitiesBundle\Tests\MotherObject\GalleryImageMotherObject;
use Runroom\EntitiesBundle\Tests\MotherObject\GalleryMotherObject;

class GalleryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itAddsAndRemovesGalleryImages()
    {
        $gallery = GalleryMotherObject::createFilled();

        $this->assertEquals(GalleryMotherObject::ID, $gallery->getId());

        $gallery_image = GalleryImageMotherObject::createFilled();

        $gallery->addGalleryImage($gallery_image);

        $gallery_images = $gallery->getGalleryImages();

        $this->assertCount(1, $gallery_images);
        $this->assertEquals(GalleryImageMotherObject::ID, $gallery_images[0]->getId());

        $gallery->removeGalleryImage($gallery_image);

        $this->assertCount(0, $gallery_images);
    }
}
