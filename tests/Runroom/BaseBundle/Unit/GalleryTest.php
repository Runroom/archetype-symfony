<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\BaseBundle\Fixtures\GalleryFixture;
use Tests\Runroom\BaseBundle\Fixtures\GalleryImageFixture;

class GalleryTest extends TestCase
{
    /**
     * @test
     */
    public function itAddsAndRemovesGalleryImages()
    {
        $gallery = GalleryFixture::createFilled();

        $this->assertSame(GalleryFixture::ID, $gallery->getId());

        $galleryImage = GalleryImageFixture::createFilled();

        $gallery->addGalleryImage($galleryImage);

        $galleryImages = $gallery->getGalleryImages();

        $this->assertCount(1, $galleryImages);
        $this->assertSame(GalleryImageFixture::ID, $galleryImages[0]->getId());

        $gallery->removeGalleryImage($galleryImage);

        $this->assertCount(0, $galleryImages);
    }
}
