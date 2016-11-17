<?php

namespace Runroom\EntitiesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="gallery")
 */
class Gallery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="gallery", cascade={"all"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $gallery_images;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->gallery_images = new ArrayCollection();
    }

    /**
     * Set id.
     *
     * @return Gallery
     */
    public function setId($id)
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

    /**
     * Add gallery_image.
     *
     * @param GalleryItem $gallery_image
     *
     * @return Gallery
     */
    public function addGalleryImage(GalleryImage $gallery_image)
    {
        $this->gallery_images[] = $gallery_image;

        $gallery_image->setGallery($this);

        return $this;
    }

    /**
     * Remove gallery_image.
     *
     * @param GalleryImage $gallery_image
     */
    public function removeGalleryImage(GalleryImage $gallery_image)
    {
        $this->gallery_images->removeElement($gallery_image);

        $gallery_image->setGallery();
    }

    /**
     * Get gallery_images.
     *
     * @return Collection
     */
    public function getGalleryImages()
    {
        return $this->gallery_images;
    }
}
