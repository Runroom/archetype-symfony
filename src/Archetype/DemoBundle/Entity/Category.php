<?php

namespace Archetype\DemoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class Category
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Book", mappedBy="category")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getName();
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

    public function setName(string $name): Category
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

    public function addBook(Book $book): Category
    {
        $this->books[] = $book;

        return $this;
    }

    public function removeBook(Book $book)
    {
        $this->books->removeElement($book);
    }

    /**
     * Get books.
     *
     * @return Collection
     */
    public function getBooks()
    {
        return $this->books;
    }
}
