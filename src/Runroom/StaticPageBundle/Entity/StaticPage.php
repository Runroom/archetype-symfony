<?php

namespace Runroom\StaticPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Runroom\BaseBundle\Entity\EntityMetaInformation;

/**
 * @ORM\Entity
 */
class StaticPage
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $publish;

    /**
     * @ORM\OneToOne(targetEntity="Runroom\BaseBundle\Entity\EntityMetaInformation", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $metaInformation;

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set id.
     *
     * @return StaticPage
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set publish.
     *
     * @param bool $publish
     *
     * @return StaticPage
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish.
     *
     * @return bool
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return StaticPage
     */
    public function setTitle($title)
    {
        $this->translate()->setTitle($title);

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->translate()->getTitle();
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return StaticPage
     */
    public function setSlug($slug)
    {
        $this->translate()->setSlug($slug);

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->translate()->getSlug();
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return StaticPage
     */
    public function setContent($content)
    {
        $this->translate()->setContent($content);

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->translate()->getContent();
    }

    /**
     * Set metaInformation.
     *
     * @param EntityMetaInformation $metaInformation
     *
     * @return StaticPage
     */
    public function setMetaInformation(EntityMetaInformation $metaInformation = null)
    {
        $this->metaInformation = $metaInformation;

        return $this;
    }

    /**
     * Get metaInformation.
     *
     * @return EntityMetaInformation
     */
    public function getMetaInformation()
    {
        return $this->metaInformation;
    }
}
