<?php

namespace Runroom\BaseBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class MetaInformation
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $route;

    /**
     * @ORM\Column(type="string")
     */
    protected $routeName;

    /**
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $image;

    public function __toString(): string
    {
        return (string) $this->getRouteName();
    }

    public function setId(?int $id): MetaInformation
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setRoute(?string $route): MetaInformation
    {
        $this->route = $route;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRouteName(?string $routeName): MetaInformation
    {
        $this->routeName = $routeName;

        return $this;
    }

    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    public function setTitle(?string $title): MetaInformation
    {
        $this->translate()->setTitle($title);

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->translate()->getTitle();
    }

    public function setDescription(?string $description): MetaInformation
    {
        $this->translate()->setDescription($description);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->translate()->getDescription();
    }

    public function setImage(Media $image = null): MetaInformation
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }
}
