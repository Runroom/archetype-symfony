<?php

namespace Runroom\SeoBundle\ViewModel;

use Sonata\MediaBundle\Model\MediaInterface;

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

    public function setImage(?MediaInterface $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?MediaInterface
    {
        return $this->image;
    }
}
