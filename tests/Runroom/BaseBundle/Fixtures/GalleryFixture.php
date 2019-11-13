<?php

namespace Tests\Runroom\BaseBundle\Fixtures;

use Runroom\BaseBundle\Entity\Gallery;

class GalleryFixture
{
    const ID = 1;

    public static function createFilled(): Gallery
    {
        $gallery = new Gallery();

        $gallery->setId(self::ID);

        return $gallery;
    }
}
