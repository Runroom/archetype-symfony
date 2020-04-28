<?php

namespace Archetype\DemoBundle\Entity;

use Archetype\DemoBundle\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Runroom\SortableBehaviorBundle\Behaviors\Sortable;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book implements TranslatableInterface
{
    use ORMBehaviors\Translatable\TranslatableTrait;
    use Sortable;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $picture;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $publish;

    public function __toString(): string
    {
        return (string) $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setPicture(?MediaInterface $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPicture(): ?MediaInterface
    {
        return $this->picture;
    }

    public function setPublish(?bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function getTitle(string $locale = null): ?string
    {
        return $this->translate($locale, false)->getTitle();
    }

    public function getDescription(string $locale = null): ?string
    {
        return $this->translate($locale, false)->getDescription();
    }
}
