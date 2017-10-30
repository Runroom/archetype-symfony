<?php

namespace Application\Sonata\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;

class Gallery extends BaseGallery
{
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
