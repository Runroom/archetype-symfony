<?php

namespace Runroom\EntitiesBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class GalleryImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $image;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="gallery_images")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $gallery;

    /**
     * Set id.
     *
     * @return GalleryImage
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
     * Set position.
     *
     * @param int $position
     *
     * @return GalleryItem
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set image.
     *
     * @param Media $image
     *
     * @return GalleryImage
     */
    public function setImage(Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set gallery.
     *
     * @param Gallery $gallery
     *
     * @return GalleryImage
     */
    public function setGallery(Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery.
     *
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}
