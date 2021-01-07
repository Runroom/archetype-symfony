<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\GalleryImageFixture;

class GalleryImageTest extends TestCase
{
    /** @test */
    public function itGetsProperties(): void
    {
        $galleryImage = GalleryImageFixture::createFilled();

        $this->assertSame(GalleryImageFixture::ID, $galleryImage->getId());
        $this->assertSame(GalleryImageFixture::IMAGE, $galleryImage->getImage());
        $this->assertSame(GalleryImageFixture::GALLERY, $galleryImage->getGallery());
        $this->assertSame(GalleryImageFixture::POSITION, $galleryImage->getPosition());
    }
}
