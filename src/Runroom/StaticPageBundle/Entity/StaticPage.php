<?php

namespace Runroom\StaticPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Runroom\BaseBundle\Behaviors as Behaviors;
use Runroom\BaseBundle\Entity\EntityMetaInformation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class StaticPage
{
    use ORMBehaviors\Translatable\Translatable;
    use Behaviors\Publishable;
    use Behaviors\MetaInformationAware;

    const LOCATION_NONE = 'none';
    const LOCATION_FOOTER = 'footer';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Assert\Choice(choices = {
     *     StaticPage::LOCATION_NONE,
     *     StaticPage::LOCATION_FOOTER,
     * })
     * @ORM\Column(type="string")
     */
    protected $location = self::LOCATION_NONE;

    public function __toString(): string
    {
        return (string) $this->getTitle();
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

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getTitle(): ?string
    {
        return $this->translate()->getTitle();
    }

    public function getSlug(): ?string
    {
        return $this->translate()->getSlug();
    }

    public function getContent(): ?string
    {
        return $this->translate()->getContent();
    }
}
