<?php

namespace Archetype\DemoBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="demo")
 */
class Demo
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media",cascade={"all"})
     * @ORM\JoinColumn(name="picture", referencedColumnName="id")
     */
    protected $picture;

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Demo
     */
    public function setName($name)
    {
        $this->translate()->setName($name);

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->translate()->getName();
    }

    /**
     * Set picture.
     *
     * @param Media $picture
     *
     * @return Demo
     */
    public function setPicture(Media $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return Media
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
