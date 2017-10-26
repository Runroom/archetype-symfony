<?php

namespace Archetype\DemoBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Runroom\BaseBundle\Behaviors as Behaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Book
{
    use ORMBehaviors\Translatable\Translatable;
    use Behaviors\Publishable;
    use Behaviors\Sortable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Assert\Valid
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="books")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $category;

    /**
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $picture;

    public function __toString(): string
    {
        return (string) $this->getTitle();
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

    public function setCategory(Category $category = null): Book
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setPicture(Media $picture = null): Book
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPicture(): ?Media
    {
        return $this->picture;
    }
}
