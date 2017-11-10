<?php

namespace Runroom\StaticPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Runroom\BaseBundle\Behaviors as Behaviors;
use Runroom\BaseBundle\Entity\EntityMetaInformation;

/**
 * @ORM\Entity
 */
class StaticPage
{
    use ORMBehaviors\Translatable\Translatable;
    use Behaviors\Publishable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Runroom\BaseBundle\Entity\EntityMetaInformation", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $metaInformation;

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

    public function setMetaInformation(EntityMetaInformation $metaInformation = null): self
    {
        $this->metaInformation = $metaInformation;

        return $this;
    }

    public function getMetaInformation(): ?EntityMetaInformation
    {
        return $this->metaInformation;
    }
}
