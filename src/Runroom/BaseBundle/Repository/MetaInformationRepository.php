<?php

namespace Runroom\BaseBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Runroom\BaseBundle\Entity\MetaInformation;

class MetaInformationRepository
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneByRoute(string $route): ?MetaInformation
    {
        $builder = $this->entityManager->createQueryBuilder();
        $query = $builder
            ->select('meta_information')
            ->from('RunroomBaseBundle:MetaInformation', 'meta_information')
            ->where('meta_information.route = :route')
            ->setParameter('route', $route)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
