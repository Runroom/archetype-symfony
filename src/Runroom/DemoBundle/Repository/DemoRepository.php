<?php

namespace Runroom\DemoBundle\Repository;

use Doctrine\ORM\EntityManager;

class DemoRepository {

    protected $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function findDemo()
    {
        $builder = $this->entity_manager->createQueryBuilder();
        $query = $builder
            ->select('demo')
            ->from('RunroomDemoBundle:Demo', 'demo')
            ->getQuery();

        return $query->getResult();
    }
}
