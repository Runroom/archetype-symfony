<?php

namespace Runroom\StaticPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Runroom\BaseBundle\Entity\EntityMetaInformation;

/**
 * @ORM\Entity
 * @ORM\Table(name="static_page")
 */
class StaticPage
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="publish", type="boolean")
     */
    protected $publish;

    /**
     * @ORM\OneToOne(targetEntity="Runroom\BaseBundle\Entity\EntityMetaInformation", cascade={"all"})
     * @ORM\JoinColumn(name="meta_information_id", referencedColumnName="id")
     */
    protected $meta_information;

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
     * Set meta_information.
     *
     * @param EntityMetaInformation $meta_information
     *
     * @return StaticPage
     */
    public function setMetaInformation(EntityMetaInformation $meta_information = null)
    {
        $this->meta_information = $meta_information;

        return $this;
    }

    /**
     * Get meta_information.
     *
     * @return EntityMetaInformation
     */
    public function getMetaInformation()
    {
        return $this->meta_information;
    }
}
