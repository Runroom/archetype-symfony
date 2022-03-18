<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGallery;

/**
 * @phpstan-extends BaseGallery<GalleryItem>
 */
#[ORM\Entity]
#[ORM\Table(name: 'media__gallery')]
class Gallery extends BaseGallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
