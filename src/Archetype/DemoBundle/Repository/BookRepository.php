<?php

namespace Archetype\DemoBundle\Repository;

use Doctrine\ORM\EntityManager;

class BookRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBooks(): array
    {
        $builder = $this->entityManager->createQueryBuilder();
        $query = $builder
            ->select('book')
            ->from('ArchetypeDemoBundle:Book', 'book')
            ->getQuery();

        return $query->getResult();
    }
}
