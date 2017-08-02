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
        return (string) $this->getTitle();
    }

    /**
     * Set id.
     *
     * @return StaticPage
     */
    public function setId(int $id): StaticPage
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
    public function setPublish(bool $publish): StaticPage
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

    public function setTitle(string $title): StaticPage
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

    public function setSlug(string $slug): StaticPage
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

    public function setContent(string $content): StaticPage
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

    public function setMetaInformation(EntityMetaInformation $metaInformation = null): StaticPage
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
