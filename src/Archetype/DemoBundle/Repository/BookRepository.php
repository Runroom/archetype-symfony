<?php

namespace Archetype\DemoBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;

class BookRepository
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBooks(): array
    {
        $builder = $this->entityManager->createQueryBuilder();
        $query = $builder
            ->select('book')
            ->from('ArchetypeDemoBundle:Book', 'book')
            ->where('book.publish = true')
            ->orderBy('book.position', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}
