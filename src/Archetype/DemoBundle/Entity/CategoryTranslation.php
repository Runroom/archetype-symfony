<?php

namespace Archetype\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class CategoryTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @Assert\NotNull
     * @ORM\Column(type="string")
     */
    protected $name;

    public function setName(string $name): CategoryTranslation
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
