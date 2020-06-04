<?php

namespace Runroom\CookiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Runroom\CookiesBundle\Repository\CookiesPageRepository;

/**
 * @ORM\Entity(repositoryClass=CookiesPageRepository::class)
 */
class CookiesPage implements TranslatableInterface
{
    use ORMBehaviors\Translatable\TranslatableTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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

    public function getTitle(string $locale = null): ?string
    {
        return $this->translate($locale, false)->getTitle();
    }

    public function getContent(string $locale = null): ?string
    {
        return $this->translate($locale, false)->getContent();
    }
}
