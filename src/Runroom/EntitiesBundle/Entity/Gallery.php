<?php

namespace Runroom\EntitiesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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

    public function setId(int $id): Gallery
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function addGalleryImage(GalleryImage $galleryImage): Gallery
    {
        $this->galleryImages[] = $galleryImage;

        $galleryImage->setGallery($this);

        return $this;
    }

    public function removeGalleryImage(GalleryImage $galleryImage)
    {
        $this->galleryImages->removeElement($galleryImage);

        $galleryImage->setGallery();
    }

    /**
     * Get galleryImages.
     *
     * @return Collection
     */
    public function getGalleryImages()
    {
        return $this->galleryImages;
    }
}
