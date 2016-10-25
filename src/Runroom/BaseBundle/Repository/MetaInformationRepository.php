<?php

namespace Runroom\BaseBundle\Repository;

use Doctrine\ORM\EntityManager;

class MetaInformationRepository
{
    protected $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function findOneByRoute($route)
    {
        $builder = $this->entity_manager->createQueryBuilder();
        $query = $builder
            ->select('meta_information')
            ->from('RunroomBaseBundle:MetaInformation', 'meta_information')
            ->where('meta_information.route = :route')
            ->setParameter('route', $route)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
