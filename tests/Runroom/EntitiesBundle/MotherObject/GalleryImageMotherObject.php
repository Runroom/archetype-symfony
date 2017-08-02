<?php

namespace Tests\Runroom\EntitiesBundle\MotherObject;

use Runroom\EntitiesBundle\Entity\GalleryImage;

class GalleryImageMotherObject
{
    const ID = 1;
    const POSITION = 1;
    const IMAGE = null;
    const GALLERY = null;

    public static function create()
    {
        return new GalleryImage();
    }

    public static function createFilled()
    {
        $galleryImage = new GalleryImage();

        $galleryImage->setId(self::ID);
        $galleryImage->setPosition(self::POSITION);
        $galleryImage->setImage(self::IMAGE);
        $galleryImage->setGallery(self::GALLERY);

        return $galleryImage;
    }
}
