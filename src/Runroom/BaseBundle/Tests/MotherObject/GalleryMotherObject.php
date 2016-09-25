<?php

namespace Runroom\BaseBundle\Tests\MotherObject;

use Runroom\BaseBundle\Entity\Gallery;

class GalleryMotherObject
{
    const ID = 1;

    public static function createFilled()
    {
        $gallery = new Gallery();

        $gallery->setId(self::ID);

        return $gallery;
    }
}
