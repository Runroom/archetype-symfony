<?php

namespace Runroom\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="entity_meta_information_translation")
 */
class EntityMetaInformationTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    protected $description;

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return EntityMetaInformationTranslation
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
     * @return EntityMetaInformationTranslation
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
