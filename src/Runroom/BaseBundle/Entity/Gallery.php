<?php

namespace Runroom\BaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Gallery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="gallery", cascade={"all"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $galleryImages;

    public function __construct()
    {
        $this->galleryImages = new ArrayCollection();
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addGalleryImage(GalleryImage $galleryImage): self
    {
        $this->galleryImages[] = $galleryImage;

        $galleryImage->setGallery($this);

        return $this;
    }

    public function removeGalleryImage(GalleryImage $galleryImage): void
    {
        $this->galleryImages->removeElement($galleryImage);

        $galleryImage->setGallery(null);
    }

    public function getGalleryImages(): ?Collection
    {
        return $this->galleryImages;
    }
}
