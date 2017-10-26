<?php

namespace Tests\Runroom\EntitiesBundle\MotherObject;

use Runroom\EntitiesBundle\Entity\Gallery;

class GalleryMotherObject
{
    const ID = 1;

    public static function createFilled(): Gallery
    {
        $gallery = new Gallery();

        $gallery->setId(self::ID);

        return $gallery;
    }
}
