<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Entity\GalleryImage;

class GalleryImageFixture
{
    /** @var int */
    public const ID = 1;

    /** @var int */
    public const POSITION = 1;

    /** @var null */
    public const IMAGE = null;

    /** @var null */
    public const GALLERY = null;

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
