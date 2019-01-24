<?php

namespace Runroom\CookiesBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Runroom\CookiesBundle\Entity\CookiesPage;

class CookiesPageRepository
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find(): CookiesPage
    {
        $builder = $this->entityManager->createQueryBuilder();
        $query = $builder
            ->select('cookies_page')
            ->from('RunroomCookiesBundle:CookiesPage', 'cookies_page')
            ->getQuery();

        return $query->getSingleResult();
    }
}
