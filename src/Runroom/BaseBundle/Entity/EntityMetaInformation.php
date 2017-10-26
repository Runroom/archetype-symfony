<?php

namespace Runroom\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class EntityMetaInformation
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function __toString(): string
    {
        return (string) $this->getTitle();
    }

    public function setId(?int $id): EntityMetaInformation
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

    public function getDescription(): ?string
    {
        return $this->translate()->getDescription();
    }
}
