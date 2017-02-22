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

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return MetaInformationTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return MetaInformationTranslation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
