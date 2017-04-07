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

    /**
     * Constructor.
     */
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

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Book
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
     * Add book.
     *
     * @param Book $book
     *
     * @return Category
     */
    public function addBook(Book $book)
    {
        $this->books[] = $book;

        return $this;
    }

    /**
     * Remove book.
     *
     * @param Book $book
     */
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
