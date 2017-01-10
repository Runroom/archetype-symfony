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
        $gallery_image = new GalleryImage();

        $gallery_image->setId(self::ID);
        $gallery_image->setPosition(self::POSITION);
        $gallery_image->setImage(self::IMAGE);
        $gallery_image->setGallery(self::GALLERY);

        return $gallery_image;
    }
}
