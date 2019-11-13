<?php

namespace Tests\Runroom\BaseBundle\Fixtures;

use Runroom\BaseBundle\Entity\GalleryImage;

class GalleryImageFixture
{
    const ID = 1;
    const POSITION = 1;
    const IMAGE = null;
    const GALLERY = null;

    public static function create(): GalleryImage
    {
        return new GalleryImage();
    }

    public static function createFilled(): GalleryImage
    {
        $galleryImage = new GalleryImage();

        $galleryImage->setId(self::ID);
        $galleryImage->setPosition(self::POSITION);
        $galleryImage->setImage(self::IMAGE);
        $galleryImage->setGallery(self::GALLERY);

        return $galleryImage;
    }
}
