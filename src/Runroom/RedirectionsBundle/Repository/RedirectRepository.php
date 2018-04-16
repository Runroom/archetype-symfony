<?php

namespace Runroom\RedirectionsBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class RedirectRepository
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findRedirect(string $source): ?array
    {
        $builder = $this->entityManager->createQueryBuilder();
        $query = $builder
            ->select('redirect.destination, redirect.httpCode')
            ->from('RunroomRedirectionsBundle:Redirect', 'redirect')
            ->where('redirect.source = :source')
            ->andWhere('redirect.publish = :publish')
            ->setParameter('source', $source)
            ->setParameter('publish', true)
            ->getQuery();

        return $query->getOneOrNullResult(Query::HYDRATE_SCALAR);
    }
}
