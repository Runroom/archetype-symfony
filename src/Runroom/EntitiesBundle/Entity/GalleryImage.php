<?php

namespace Runroom\EntitiesBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Runroom\BaseBundle\Behaviors\Sortable;
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
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $image;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Gallery", inversedBy="galleryImages")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $gallery;

    public function setId(int $id): GalleryImage
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

    public function setImage(Media $image = null): GalleryImage
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

    public function setGallery(Gallery $gallery = null): GalleryImage
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
