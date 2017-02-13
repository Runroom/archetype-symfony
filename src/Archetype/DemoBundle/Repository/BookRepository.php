<?php

namespace Archetype\DemoBundle\Repository;

use Doctrine\ORM\EntityManager;

class BookRepository
{
    protected $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function findBooks()
    {
        $builder = $this->entity_manager->createQueryBuilder();
        $query = $builder
            ->select('book')
            ->from('ArchetypeDemoBundle:Book', 'book')
            ->getQuery();

        return $query->getResult();
    }
}
