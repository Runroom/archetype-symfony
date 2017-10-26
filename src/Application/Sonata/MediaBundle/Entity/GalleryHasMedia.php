<?php

namespace Application\Sonata\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGalleryHasMedia as BaseGalleryHasMedia;

class GalleryHasMedia extends BaseGalleryHasMedia
{
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
