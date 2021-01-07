<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\GalleryFixture;
use Tests\Fixtures\GalleryImageFixture;

class GalleryTest extends TestCase
{
    /** @test */
    public function itAddsAndRemovesGalleryImages(): void
    {
        $gallery = GalleryFixture::createFilled();

        $this->assertSame(GalleryFixture::ID, $gallery->getId());

        $galleryImage = GalleryImageFixture::createFilled();

        $gallery->addGalleryImage($galleryImage);

        $galleryImages = $gallery->getGalleryImages();

        $this->assertCount(1, $galleryImages);

        $gallery->removeGalleryImage($galleryImage);

        $this->assertCount(0, $galleryImages);
    }
}
