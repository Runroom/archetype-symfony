<?php

namespace Runroom\BaseBundle\ViewModel;

use Runroom\BaseBundle\Entity\Media;

class MetaInformationViewModel
{
    protected $title;
    protected $description;
    protected $image;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setImage(?Media $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }
}
