<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGalleryItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="media__gallery_media")
 */
class GalleryItem extends BaseGalleryItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
