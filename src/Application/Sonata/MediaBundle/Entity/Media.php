<?php

namespace Application\Sonata\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

class Media extends BaseMedia
{
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
