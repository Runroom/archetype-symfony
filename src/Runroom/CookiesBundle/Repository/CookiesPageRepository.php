<?php

namespace Runroom\CookiesBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Runroom\CookiesBundle\Entity\CookiesPage;

class CookiesPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CookiesPage::class);
    }
}
