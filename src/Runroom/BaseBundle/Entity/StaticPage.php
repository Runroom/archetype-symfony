<?php

namespace Runroom\BaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Choice(choices = {"none", "footer"})
     * @ORM\Column(name="location", type="string")
     */
    protected $location;

    /**
     * @ORM\Column(name="publish", type="boolean")
     */
    protected $publish;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

    /**
     * @ORM\OneToOne(targetEntity="EntityMetaInformation", cascade={"all"})
     * @ORM\JoinColumn(name="meta_information_id", referencedColumnName="id")
     */
    protected $meta_information;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->casinos = new ArrayCollection();
    }

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
     * Set location.
     *
     * @param string $location
     *
     * @return StaticPage
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
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
     * Set position.
     *
     * @param int $position
     *
     * @return StaticPage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
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
     * Set breadcrumb.
     *
     * @param string $breadcrumb
     *
     * @return StaticPage
     */
    public function setBreadcrumb($breadcrumb)
    {
        $this->translate()->setBreadcrumb($breadcrumb);

        return $this;
    }

    /**
     * Get breadcrumb.
     *
     * @return string
     */
    public function getBreadcrumb()
    {
        return $this->translate()->getBreadcrumb();
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
