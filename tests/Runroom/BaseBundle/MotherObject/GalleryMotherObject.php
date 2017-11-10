<?php

namespace Tests\Runroom\BaseBundle\MotherObject;

use Runroom\BaseBundle\Entity\Gallery;

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
