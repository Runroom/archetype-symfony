<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGalleryHasMedia;

/**
 * @ORM\Entity
 * @ORM\Table(name="media__gallery_media")
 */
class SonataGalleryHasMedia extends BaseGalleryHasMedia
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
