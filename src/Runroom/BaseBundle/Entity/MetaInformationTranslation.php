<?php

namespace Runroom\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class MetaInformationTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @Assert\NotNull
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @Assert\NotNull
     * @ORM\Column(type="text")
     */
    protected $description;

    public function setTitle(?string $title): MetaInformationTranslation
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(?string $description): MetaInformationTranslation
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
