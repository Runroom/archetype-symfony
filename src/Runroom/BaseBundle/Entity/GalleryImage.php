<?php

namespace Runroom\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Runroom\SortableBehaviorBundle\Behaviors\Sortable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class GalleryImage
{
    use Sortable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="Media", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $image;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="galleryImages")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $gallery;

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImage(?Media $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setGallery(?Gallery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }
}
