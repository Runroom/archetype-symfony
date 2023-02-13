<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Menu implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxDepth = null;

    #[ORM\OneToOne(targetEntity: MenuItem::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(referencedColumnName: 'id')]
    private ?MenuItem $root = null;

    public function __toString(): string
    {
        return $this->title ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title = null): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setMaxDepth(int $maxDepth = null): void
    {
        $this->maxDepth = $maxDepth;
    }

    public function getMaxDepth(): ?int
    {
        return $this->maxDepth;
    }

    public function setRoot(MenuItem $root = null): void
    {
        $this->root = $root;
    }

    public function getRoot(): ?MenuItem
    {
        return $this->root;
    }
}
